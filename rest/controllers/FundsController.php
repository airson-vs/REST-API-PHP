<?php

/**
 * 
 * @package api-framework
 * @author  Jugal Kishor <jugal.lalriya@gmail.com>
 */

class FundsController extends AbstractController {
    /**
     * GET method.
     * 
     * @param  Request $request
     * @return string
     */
    public function get($request) {
    
        $founds = $this->readFounds();
        switch (count($request->url_elements)) {
            case 1:
                return $founds;
                break;           
            case 3:
                return $founds;
                break;
        }
    }

    /**
     * Read founds.
     *
     * @return array
     */
    protected function readFounds() {
        $founds = null;
include 'config.php';
$conn = mssql_jp_connect();
    if ($conn) {
        $table_name = "job_a_02_all_funds";
     $db_array_col = array(
     "id", 
     "parent_fund", 
     "fund", 
     "type", 
     "amc",
	 "fund_code",
	 "nav_date",
	 "nav",
	 "fund_size",
	 "boll_upper",
	 "boll_mid",
	 "boll_lower",
	 "trading_gap",
	 "current_percentage",
	 "upside_grain",
	 "week_1",
	 "month_1",
	 "month_3",
	 "month_6",
	 "year_1",
	 "year_3",
	 "year_5",
	 "sharpe_ratio"
     );

    $tsql = "SELECT * FROM $table_name";//order by id DESC

    $stmt = sqlsrv_query($conn, $tsql);
    if ($stmt === false) {
        echo "Error in query preparation/execution.\n";
        die(print_r(sqlsrv_errors(), true));
    }

    $rows = sqlsrv_has_rows($stmt);

    if ($rows === true) {
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

$found['ParentFund']=trim($row['parent_fund']);
$found['Fund']=trim($row['fund']);

$found['Type']=trim($row['type']);

$found['AMC']=trim($row['amc']);

$found['FundCode']=trim($row['fund_code']);
$found['NAV']=$this->convertToNeg($row['nav']);
$found['FundSize']=$this->convertToNeg($row['fund_size']);
$found['1Week']=$this->convertToNeg($row['week_1']);
$found['1Month']=$this->convertToNeg($row['month_1']);
$found['3Month']=$this->convertToNeg($row['month_3']);
$found['6Month']=$this->convertToNeg($row['month_6']);
$found['1Year']=$this->convertToNeg($row['year_1']);
$found['3Year']=$this->convertToNeg($row['year_3']);
$found['5Year']=$this->convertToNeg($row['year_5']);
$found['SharpeRatio']=$this->convertToNeg($row['sharpe_ratio']);
$founds[]=$found;
        }
        
    }
	else
	{
	$found='No Record found';
	$founds[]=$found;
	}
	}else {
        return "Connection could not be established.\n";
        die(print_r(sqlsrv_errors(), true));
    }
    sqlsrv_close($conn);
        
        return $founds;
    }
protected function convertToNeg($inval)
     {
     if($inval=='')
	{
		return null;
	}
	else
	{
		$inval=trim($inval);
		$inval=str_replace("(", "-", $inval);
		$inval=str_replace(")", "", $inval);
		return floatval($inval);
	}
     }
}
?>