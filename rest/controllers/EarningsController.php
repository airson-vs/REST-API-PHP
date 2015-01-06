<?php

/**
 * 
 * @package api-framework
 * @author  Jugal Kishor <jugal.lalriya@gmail.com>
 */
class EarningsController extends AbstractController {
    /**
     * GET method.
     * 
     * @param  Request $request
     * @return string
     */
    public function get($request) {        
        $earnings = $this->readEarnings();
        switch (count($request->url_elements)) {
            case 1:
                return $earnings;
                break;           
            case 3:
                return $earnings;
                break;
        }
    }

    /**
     * Read earnings.
     *
     * @return array
     */
    protected function readEarnings() {
        $earnings = null;
include 'config.php';
$conn = mssql_jp_connect();
    if ($conn) {
        $table_name = "job_a_04_earning_guide";
     $db_array_col = array(
     "id"
      ,"parent"
      ,"child"
      ,"market_cap_btm"
      ,"price_bt_2_sep"
      ,"target_price_bt"
      ,"percent_upside"
      ,"rcmd"
      ,"net_profit_btm_11a"
      ,"net_profit_btm_12a"
      ,"net_profit_btm_13a"
      ,"net_profit_btm_14f"
      ,"net_profit_btm_15f"
      ,"net_profit_gth_prcnt_12a"
      ,"net_profit_gth_prcnt_13f"
      ,"net_profit_gth_prcnt_14f"
      ,"eps_bt_11a"
      ,"eps_bt_12a"
      ,"eps_bt_13a"
      ,"eps_bt_14f"
      ,"eps_bt_15f"
      ,"eps_gth_percent_12a"
      ,"eps_gth_percent_13a"
      ,"eps_gth_percent_14f"
      ,"eps_gth_percent_15f"
      ,"pe_x_11a"
      ,"pe_x_12a"
      ,"pe_x_13a"
      ,"pe_x_14f"
      ,"pe_x_15f"
      ,"peg_13a"
      ,"peg_14f"
      ,"peg_15f"
      ,"bps_bt_12a"
      ,"bps_bt_13f"
      ,"bps_bt_14f"
      ,"bps_bt_15f"
      ,"pbv_x_12a"
      ,"pbv_x_13a"
      ,"pbv_x_14f"
      ,"pbv_x_15f"
      ,"dps_bt_12a"
      ,"dps_bt_13a"
      ,"dps_bt_14f"
      ,"dps_bt_15f"
      ,"div_yield_percent_12a"
      ,"div_yield_percent_13a"
      ,"div_yield_percent_14f"
      ,"div_yield_percent_15f"
      ,"net_debt_equity_x_13a"
      ,"roe_percent_13a"
      ,"set50"
      ,"set100"
      
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
   $earning['SectorID']=trim($row['parent']);
   $earning['StockID']=trim($row['child']);
   $earning['MarketCap']=trim($row['market_cap_btm']);
   $earning['PriceForecast']=$this->convertToNeg($row['target_price_bt']);
   $earning['PercentUpside']=$this->BlankToNull($row['percent_upside']);
   $earning['Recommend']=trim($row['rcmd']);
$earning['NetProfit1']=$this->convertToNeg($row['net_profit_btm_11a']);
$earning['NetProfit2']=$this->convertToNeg($row['net_profit_btm_12a']);
$earning['NetProfit3']=$this->convertToNeg($row['net_profit_btm_13a']);
$earning['NetProfit4']=$this->convertToNeg($row['net_profit_btm_14f']);
$earning['NetProfit5']=$this->convertToNeg($row['net_profit_btm_15f']);
$earning['EPS1']=$this->convertToNeg($row['eps_bt_11a']);
$earning['EPS2']=$this->convertToNeg($row['eps_bt_12a']);
$earning['EPS3']=$this->convertToNeg($row['eps_bt_13a']);
$earning['EPS4']=$this->convertToNeg($row['eps_bt_14f']);
$earning['EPS5']=$this->convertToNeg($row['eps_bt_15f']);
$earning['PE1']=$this->convertToNeg($row['pe_x_11a']);
$earning['PE2']=$this->convertToNeg($row['pe_x_12a']);
$earning['PE3']=$this->convertToNeg($row['pe_x_13a']);
$earning['PE4']=$this->convertToNeg($row['pe_x_14f']);
$earning['PE5']=$this->convertToNeg($row['pe_x_15f']);
$earning['PEG1']=$this->convertToNeg($row['peg_13a']);
$earning['PEG2']=$this->convertToNeg($row['peg_14f']);
$earning['PEG3']=$this->convertToNeg($row['peg_15f']);
$earning['BPS1']=$this->convertToNeg($row['bps_bt_12a']);
$earning['BPS2']=$this->convertToNeg($row['bps_bt_13f']);
$earning['BPS3']=$this->convertToNeg($row['bps_bt_14f']);
$earning['BPS4']=$this->convertToNeg($row['bps_bt_15f']);
$earning['PBV1']=$this->convertToNeg($row['pbv_x_12a']);
$earning['PBV2']=$this->convertToNeg($row['pbv_x_13a']);
$earning['PBV3']=$this->convertToNeg($row['pbv_x_14f']);
$earning['PBV4']=$this->convertToNeg($row['pbv_x_15f']);
$earning['DPS1']=$this->convertToNeg($row['dps_bt_12a']);
$earning['DPS2']=$this->convertToNeg($row['dps_bt_13a']);
$earning['DPS3']=$this->convertToNeg($row['dps_bt_14f']);
$earning['DivYield1']=$this->convertToNeg($row['div_yield_percent_12a']);
$earning['DivYield2']=$this->convertToNeg($row['div_yield_percent_13a']);
$earning['DivYield3']=$this->convertToNeg($row['div_yield_percent_14f']);
$earning['DivYield4']=$this->convertToNeg($row['div_yield_percent_15f']);
$earning['NetDebt']=trim($row['net_debt_equity_x_13a']);
$earning['ROE']=$this->convertToNeg($row['roe_percent_13a']);

   	if($row['set50']==1)
		{
		$Set50=true;
		}
		else
		{
		$Set50=false;
		}
		if($row['set100']==1)
		{
		$Set100=true;
		}
		else
		{
		$Set100=false;
		}
   $earning['FlagSET50']=$Set50;
   $earning['FlagSET100']=$Set100;
        $earnings[]=$earning;
        
        }
        
    } 
	}else {
        return "Connection could not be established.\n";
        die(print_r(sqlsrv_errors(), true));
    }
    sqlsrv_close($conn);
        
        return $earnings;
    }
     protected function BlankToNull($inval)
     {
     if($inval=='')
	{
		return null;
	}
	else
	{
		$inval=trim($inval);		
		return $inval;
	}
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