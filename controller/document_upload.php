<?php

/**
 * upload.php
 *
 * Copyright 2013, Moxiecode Systems AB
 * Released under GPL License.
 *
 * License: http://www.plupload.com/license
 * Contributing: http://www.plupload.com/contributing
 */
#!! IMPORTANT: 
#!! this file is just an example, it doesn't incorporate any security checks and 
#!! is not recommended to be used in production environment as it is. Be sure to 
#!! revise it and customize to your needs.
// Make sure file is not cached (as it happens for example on iOS devices)
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

/* ==========================================================================
  PHP Excel reader
  ========================================================================== */
error_reporting(E_ALL);
set_time_limit(0);
date_default_timezone_set('Europe/London');
include '../classes/PHPExcel/IOFactory.php';


/* ==========================================================================
  Db connectivity
  ========================================================================== */
include '../config.php';
$conn = mssql_jp_connect();


/*
  // Support CORS
  header("Access-Control-Allow-Origin: *");
  // other CORS headers if any...
  if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
  exit; // finish preflight CORS requests here
  }
 */

// 5 minutes execution time
@set_time_limit(5 * 60);
ini_set('post_max_size', '6M');
ini_set('upload_max_filesize', '6M');
// Uncomment this one to fake upload time
// usleep(5000);
// Settings
//$targetDir = ini_get("upload_tmp_dir") . DIRECTORY_SEPARATOR . "plupload";
$targetDir = dirname(realpath('./')) . DIRECTORY_SEPARATOR . 'upload_temp' . DIRECTORY_SEPARATOR . 'documents' . DIRECTORY_SEPARATOR;

$cleanupTargetDir = false; // Remove old files
$maxFileAge = 5 * 3600; // Temp file age in seconds
// Create target dir
if (!file_exists($targetDir)) {
    @mkdir($targetDir);
}

// Get a file name
if (isset($_REQUEST["name"])) {
    $fileName = $_REQUEST["name"];
} elseif (!empty($_FILES)) {
    $fileName = $_FILES["file"]["name"];
} else {
    $fileName = uniqid("file_");
}

$filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;

// Chunking might be enabled
$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;


// Remove old temp files	
if ($cleanupTargetDir) {
    if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
        die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
    }

    while (($file = readdir($dir)) !== false) {
        $tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;

        // If temp file is current file proceed to the next
        if ($tmpfilePath == "{$filePath}.part") {
            continue;
        }

        // Remove temp file if it is older than the max age and is not the current file
        if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge)) {
            @unlink($tmpfilePath);
        }
    }
    closedir($dir);
}


// Open temp file
if (!$out = @fopen("{$filePath}.part", $chunks ? "ab" : "wb")) {
    die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
}

if (!empty($_FILES)) {
    if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
        die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
    }

    // Read binary input stream and append it to temp file
    if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
        die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
    }
} else {
    if (!$in = @fopen("php://input", "rb")) {
        die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
    }
}

while ($buff = fread($in, 4096)) {
    fwrite($out, $buff);
}

@fclose($out);
@fclose($in);

// Check if file has been uploaded
if (!$chunks || $chunk == $chunks - 1) {
    // Strip the temp .part suffix off
    if (file_exists($filePath)) {
        unlink($filePath);
    }
    rename("{$filePath}.part", $filePath);
}





/* ==========================================================================
  Pumping training_center_english excel file to DB in to Training_center
  ========================================================================== */
if ($_GET['action'] == 'training_center') {
    $objPHPExcel = PHPExcel_IOFactory::load($filePath);
    $row_array = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

    if ($_GET['language'] == 'english') {
        $table_name = "job_a_05_training_en";
    } else {
        $table_name = "job_a_05_training_th";
    }
    $tsq3_truncate = "truncate table $table_name";
    sqlsrv_query($conn, $tsq3_truncate);

    foreach ($row_array as $key => $row_val) {
        if ($key > 4) {
            if (!empty($row_val['B'])) {
                $params = array(str_replace('-', '/', $row_val['B']), $row_val['C'], str_replace('-', '/', $row_val['D']), $row_val['E'], $row_val['F'], $row_val['G'], $row_val['H'], $row_val['I'], $row_val['J'],
                    $row_val['K'], $row_val['L'], $row_val['M'], $row_val['N'], $row_val['O'], $row_val['P'], $row_val['Q'], $row_val['R'], $row_val['S'], $row_val['T']); //

                $tsql_insert = "INSERT INTO $table_name
           (start_date
           ,start_time_24hrs
           ,end_date
           ,end_time_24hrs
           ,location
           ,capacity
          ,fee
          ,short_course_name
          ,course_name
          ,category_name
          ,course_code
          ,objective
          ,course_outline
          ,course_speaker
          ,course_level
          ,course_language
          ,course_status
          ,keywords
          ,remarks
           ) VALUES
           (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

                sqlsrv_query($conn, $tsql_insert, $params) or die(print_r(sqlsrv_errors(), true));
            }
        };
    }
}


/* ==========================================================================
  Pumping training_center_english excel file to DB in to Earning Guide
  ========================================================================== */
if ($_GET['action'] == 'earning_guide') {
    $objPHPExcel = PHPExcel_IOFactory::load($filePath);
    $row_array = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

    $tsq3_truncate = "truncate table job_a_04_earning_guide";
    sqlsrv_query($conn, $tsq3_truncate);
    for ($i = 5, $parent = 1; $i <= count($row_array);) {

        if (empty($row_array[$i]['B'])) {

            for ($j = $i, $parent = $row_array[$i]['A']; $j <= count($row_array); $j++, $i++) {
                if (!empty($row_array[$j]['B'])) {
		if(strtolower($row_array[$j]['AX'])=='set50')
		{
		$Set50=true;
		}
		else
		{
		$Set50=false;
		}
		if(strtolower($row_array[$j]['AY'])=='set100')
		{
		$Set100=true;
		}
		else
		{
		$Set100=false;
		}
                    $params = array($parent, $row_array[$j]['A'], $row_array[$j]['B'], $row_array[$j]['C'], $row_array[$j]['D'], $row_array[$j]['E'], $row_array[$j]['F'], $row_array[$j]['G'], $row_array[$j]['H'], $row_array[$j]['I'], $row_array[$j]['J'],
                        $row_array[$j]['K'], $row_array[$j]['L'], $row_array[$j]['M'], $row_array[$j]['N'], $row_array[$j]['O'], $row_array[$j]['P'], $row_array[$j]['Q'], $row_array[$j]['R'], $row_array[$j]['S'], $row_array[$j]['T'],
                        $row_array[$j]['U'], $row_array[$j]['V'], $row_array[$j]['W'], $row_array[$j]['X'], $row_array[$j]['Y'], $row_array[$j]['Z'],
                        $row_array[$j]['AA'], $row_array[$j]['AB'], $row_array[$j]['AC'], $row_array[$j]['AD'], $row_array[$j]['AE'], $row_array[$j]['AF'], $row_array[$j]['AG'], $row_array[$j]['AH'], $row_array[$j]['AI'], $row_array[$j]['AJ'],
                        $row_array[$j]['AK'], $row_array[$j]['AL'], $row_array[$j]['AM'], $row_array[$j]['AN'], $row_array[$j]['AO'], $row_array[$j]['AP'], $row_array[$j]['AQ'], $row_array[$j]['AR'], $row_array[$j]['AS'], $row_array[$j]['AT'],
                         $row_array[$j]['AU'], $row_array[$j]['AV'], $row_array[$j]['AW'], $Set50, $Set100); //

                    // echo $row_array[$j]['A'] . '<br>';
                    if (trim($row_array[$j]['A']) != 'Sector') {
                        if (trim($row_array[$j]['A']) != 'Total Market') {

                            $tsql_insert = "INSERT INTO job_a_04_earning_guide
           (parent, child, market_cap_btm, price_bt_2_sep, target_price_bt, percent_upside, rcmd,
                    net_profit_btm_11a, net_profit_btm_12a, net_profit_btm_13a, net_profit_btm_14f, net_profit_btm_15f, net_profit_gth_prcnt_12a, net_profit_gth_prcnt_13f, net_profit_gth_prcnt_14f,
                    eps_bt_11a, eps_bt_12a, eps_bt_13a, eps_bt_14f, eps_bt_15f, eps_gth_percent_12a, eps_gth_percent_13a, eps_gth_percent_14f, eps_gth_percent_15f, pe_x_11a, pe_x_12a, pe_x_13a, pe_x_14f
                    , pe_x_15f, peg_13a, peg_14f, peg_15f, bps_bt_12a, bps_bt_13f, bps_bt_14f, bps_bt_15f, pbv_x_12a, pbv_x_13a
                    , pbv_x_14f, pbv_x_15f, dps_bt_12a, dps_bt_13a, dps_bt_14f, dps_bt_15f, div_yield_percent_12a, div_yield_percent_13a, div_yield_percent_14f, div_yield_percent_15f
                    , net_debt_equity_x_13a, roe_percent_13a, set50,set100
           ) VALUES
           (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,
           ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,
           ?,?,?,?,?,?,?,?,?,?,?,?)";

                            sqlsrv_query($conn, $tsql_insert, $params) or die(print_r(sqlsrv_errors(), true));
                        }
                    }
                } else {
                    $parent = $row_array[$j]['A'];
                }
            }
        }
    }
}


/* ==========================================================================
  Pumping job_a_01_underlying excel file to DB in to underlying
  ========================================================================== */
if ($_GET['action'] == 'underlying') {
    $objPHPExcel = PHPExcel_IOFactory::load($filePath);
    $row_array = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);    
    $tsq3_truncate = "truncate table job_a_01_underlying";
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'HTML');
    $excel_html = $objWriter->save_excel_to_html_underlying('php://output');
//$excel_html='<table>'.$filePath .'</table>';
$excel_html = str_replace("\n", "", $excel_html);
$excel_html = str_replace("\r", "", $excel_html);
$excel_html = str_replace("\"", "'", $excel_html);
$excel_html = str_replace("\t", "", $excel_html);
$excel_html = str_replace("\/", "/", $excel_html);
$excel_html=trim($excel_html);
    if (empty($excel_html)) {
        $excel_html = 'no data';
    }

    sqlsrv_query($conn, $tsq3_truncate);
    $params = array('underlying', ($excel_html));
    $tsql_insert = "INSERT INTO job_a_01_underlying(sheet_name, excel_data) VALUES(?,?)";
    print_r(json_encode($excel_html));
//echo $tsql_insert;   
    sqlsrv_query($conn, $tsql_insert, $params) or die(print_r(sqlsrv_errors(), true));
}

/* ==========================================================================
  Pumping training_center_english excel file to DB in to SSF
  ========================================================================== */
if ($_GET['action'] == 'ssf') {
    
        /* ==========================================================================
      Loading the Excel file on run time and pumping the data from Excel to Sql server
      ========================================================================== */
    $objPHPExcel = PHPExcel_IOFactory::load($filePath);
    $row_array = $objPHPExcel->getSheet(1)->toArray(null, true, true, true);
    
    $tsq3_truncate = "truncate table job_a_01_ssf";

    sqlsrv_query($conn, $tsq3_truncate);
    foreach ($row_array as $key => $row_val) {
        if ($key > 3) {
            if (!empty($row_val['B'])) {
                $params = array($row_val['A'],$row_val['B'], $row_val['C'], $row_val['D'], $row_val['E'], $row_val['F'], $row_val['G']); //

                $tsql_insert = "INSERT INTO job_a_01_ssf(ssf, mr_or_im, mr_or_mm, mr_or_fm, mr_fm_im, mr_fm_mm, mr_fm_fm) VALUES(?,?,?,?,?,?,?)";
                sqlsrv_query($conn, $tsql_insert, $params) or die(print_r(sqlsrv_errors(), true));
            }
        }
    }
}


/* ==========================================================================
  Pumping training_center_english excel file to DB in to All Funds
  ========================================================================== */
if ($_GET['action'] == 'all_funds') {

    $objPHPExcel = PHPExcel_IOFactory::load($filePath);
    $row_array = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
    $tsq3_truncate = "truncate table job_a_02_all_funds";
    sqlsrv_query($conn, $tsq3_truncate);

    for ($i = 2, $parent = 1; $i <= count($row_array);) {
        if (empty($row_array[$i]['B'])) {
            for ($j = $i, $parent = $row_array[$i]['A']; $j <= count($row_array); $j++, $i++) {
                if (!empty($row_array[$j]['B'])) { //!empty($row_array[$j]['A']) &&
                    // if (!empty($row_array[$j]['A']) && !empty($row_array[$j]['B']) && !empty($row_array[$j]['C']) && !empty($row_array[$j]['D'])) {
                    if ($row_array[$j]['B'] != '') {
                        $params = array($parent, $row_array[$j]['A'], $row_array[$j]['B'], $row_array[$j]['C'], $row_array[$j]['D'], $row_array[$j]['E'], $row_array[$j]['F'], 
			$row_array[$j]['G'], $row_array[$j]['H'], $row_array[$j]['I'], $row_array[$j]['J'],$row_array[$j]['K'], $row_array[$j]['L'], $row_array[$j]['M'],
			 $row_array[$j]['N'], $row_array[$j]['O'], $row_array[$j]['P'], $row_array[$j]['Q'], $row_array[$j]['R'], $row_array[$j]['S'], $row_array[$j]['T'], 
			 $row_array[$j]['U']); //

                        $tsql_insert = "INSERT INTO job_a_02_all_funds(parent_fund, fund, type, amc, fund_code, nav_date, nav, 
			fund_size,boll_upper, boll_mid, boll_lower, trading_gap, current_percentage, upside_grain,week_1, month_1, month_3, month_6, year_1 , year_3, year_5,
			 sharpe_ratio)
                    VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                        sqlsrv_query($conn, $tsql_insert, $params) or die(print_r(sqlsrv_errors(), true));
                    }
                } else {
                    $parent = $row_array[$j]['A'];
                }
            }
        }
    }
}

/* ==========================================================================
  Pumping job_a_03_recommendation_html excel file to DB in to Fund Recommendation
  ========================================================================== */
if ($_GET['action'] == 'fund_recommendation') {
    $objPHPExcel = PHPExcel_IOFactory::load($filePath);
    $row_array = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);    
    $tsq3_truncate = "truncate table job_a_03_recommendation";
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'HTML');
    $excel_html = $objWriter->save_excel_to_html_fr('php://output');
//$excel_html='<table>'.$filePath .'</table>';
$excel_html = str_replace("\n", "", $excel_html);
$excel_html = str_replace("\r", "", $excel_html);
$excel_html = str_replace("\"", "'", $excel_html);
$excel_html = str_replace("\t", "", $excel_html);
$excel_html = str_replace("\/", "/", $excel_html);
$excel_html=trim($excel_html);
    if (empty($excel_html)) {
        $excel_html = 'no data';
    }

    sqlsrv_query($conn, $tsq3_truncate);
    $params = array('recommendation', ($excel_html));
    $tsql_insert = "INSERT INTO job_a_03_recommendation(sheet_name, excel_data) VALUES(?,?)";
    print_r(json_encode($excel_html));
//echo $tsql_insert;   
    sqlsrv_query($conn, $tsql_insert, $params) or die(print_r(sqlsrv_errors(), true));
}


/* ==========================================================================
  Pumping sp_upload_documents excel file to DB in to Fund Recommendation
  ========================================================================== */
if ($_GET['action'] == 'sp_upload_documents') {

    $objPHPExcel = PHPExcel_IOFactory::load($filePath);
    $row_array = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

    $tsq3_truncate = "DELETE FROM job_b_sp_upload_documents";
    sqlsrv_query($conn, $tsq3_truncate);

    foreach ($row_array as $key => $row_val) {
        if ($key > 2) {
            if (!(empty($row_val['A']) && empty($row_val['B']) && empty($row_val['C']) && empty($row_val['D']) && empty($row_val['E']) && empty($row_val['F']) 
	    && empty($row_val['G']) && empty($row_val['H']) && empty($row_val['I']) && empty($row_val['J']) && empty($row_val['K']) && empty($row_val['L']) 
	    && empty($row_val['M']) && empty($row_val['N']) && empty($row_val['O']) && empty($row_val['P']) && empty($row_val['Q']) && empty($row_val['R']) 
	    && empty($row_val['S']) && empty($row_val['T']) && empty($row_val['U']) && empty($row_val['V']) && empty($row_val['W']) && empty($row_val['X']) 
	    && empty($row_val['Y']) && empty($row_val['Z']))) {
                $params = array($row_val['A'], $row_val['B'], $row_val['C'], $row_val['D'],$row_val['E'],$row_val['F'],$row_val['G'],$row_val['H'],$row_val['I'],$row_val['J'],$row_val['K'],$row_val['L'],$row_val['M'],$row_val['N'],$row_val['O'],$row_val['P'],$row_val['Q'],$row_val['R'],$row_val['S'],$row_val['T'],$row_val['U'],$row_val['V'],$row_val['W'],$row_val['X'],$row_val['Y'],$row_val['Z']); //

                $tsql_insert = "INSERT INTO job_b_sp_upload_documents(Type,Date,ShareCounter,SpotPrice,P_StrikeofSpot,StrikePrice,P_KnockOut,KnockoutPrice,P_ProtectionLevelofSpot,ProtectionLevelPrice,P_UpperLevelPrice,UpperLevelPrice,TradeDate,IssueDate,ValuationDate,MaturityDate,NoofDays,NominalAmount,YieldbeforeTax,InterestEarn,Withholdingtax,TotalSettlementAmount_RedemptionAmountinCash_THB,YieldAfterTax,NoOfShare,Comments,LossProtectionAmount) 
		VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                sqlsrv_query($conn, $tsql_insert, $params) or die(print_r(sqlsrv_errors(), true));
            }
        }
    }
sqlsrv_close($conn);
}

/* ==========================================================================
  Pumping job_a_06_term_fund_information excel file to DB in to Term Fund Information
  ========================================================================== */
if ($_GET['action'] == 'term_fund_information') {
    $objPHPExcel = PHPExcel_IOFactory::load($filePath);
    $row_array = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);    
    $tsq3_truncate = "truncate table job_a_06_term_fund_information";
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'HTML');
    $excel_html = $objWriter->save_excel_to_html_term('php://output');
$excel_html = str_replace("\n", "", $excel_html);
$excel_html = str_replace("\r", "", $excel_html);
$excel_html = str_replace("\"", "'", $excel_html);
$excel_html = str_replace("\t", "", $excel_html);
$excel_html = str_replace("\/", "/", $excel_html);
$excel_html=trim($excel_html);
    if (empty($excel_html)) {
        $excel_html = 'no data';
    }

    sqlsrv_query($conn, $tsq3_truncate);
    $params = array('underlying', ($excel_html));
    $tsql_insert = "INSERT INTO job_a_06_term_fund_information(sheet_name, excel_data) VALUES(?,?)";
    print_r(json_encode($excel_html));
//echo $tsql_insert;   
    sqlsrv_query($conn, $tsql_insert, $params) or die(print_r(sqlsrv_errors(), true));
}


// Return Success JSON-RPC response
die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');
