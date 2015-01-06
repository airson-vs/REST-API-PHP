<?php

/**
 * 
 * @package api-framework
 * @author  Jugal Kishor <jugal.lalriya@gmail.com>
 */
class ProductsController extends AbstractController {
    /**
     * GET method.
     * 
     * @param  Request $request
     * @return string
     */
    public function get($request) {
    
        $products = $this->readProducts();
        switch (count($request->url_elements)) {
            case 1:
                return $products;
                break;           
            case 3:
                return $products;
                break;
        }
    }

    /**
     * Read products.
     *
     * @return array
     */
    protected function readProducts() {
        $products = null;
include 'config.php';
$conn = mssql_jp_connect();

    if ($conn) {
        $table_name = "job_b_sp_upload_documents";
     $db_array_col = array("Type","Date","ShareCounter","SpotPrice","StrikePricePct","StrikePrice","KnockOutPricePct","KnockoutPrice","ProtectionLevelPricePct","ProtectionLevelPrice","UpperLevelPricePct","UpperLevelPrice","TradeDate","IssueDate","ValuationDate","MaturityDate","NoOfDays","NominalAmount","YieldBeforeTax","InterestEarn","WithHoldingTax","TotalSettlementAmount","YieldAfterTax","NoOfShare","Comments","LossProtectionAmount");

    $tsql = "SELECT * FROM $table_name";//order by id DESC

    $stmt = sqlsrv_query($conn, $tsql);
    if ($stmt === false) {
        echo "Error in query preparation/execution.\n";
        die(print_r(sqlsrv_errors(), true));
    }

    $rows = sqlsrv_has_rows($stmt);

    if ($rows === true) {
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
$product['Type']=trim($row['Type']);
$product['Date']=trim($row['Date']);
$product['ShareCounter']=$this->BlankToNull($row['ShareCounter']);
$product['SpotPrice']=$this->convertToNeg($row['SpotPrice']);
$product['StrikePricePct']=$this->BlankToNull($row['StrikePricePct']);
$product['StrikePrice']=$this->convertToNeg($row['StrikePrice']);
$product['KnockOutPricePct']=$this->BlankToNull($row['KnockOutPricePct']);
$product['KnockOutPrice']=$this->convertToNeg($row['KnockoutPrice']);
$product['ProtectionLevelPricePct']=$this->BlankToNull($row['ProtectionLevelPricePct']);
$product['ProtectionLevelPrice']=$this->convertToNeg($row['ProtectionLevelPrice']);
$product['UpperLevelPricePct']=$this->BlankToNull($row['UpperLevelPricePct']);
$product['UpperLevelPrice']=$this->convertToNeg($row['UpperLevelPrice']);
$product['TradeDate']=trim($row['TradeDate']);
$product['IssueDate']=trim($row['IssueDate']);
$product['ValuationDate']=trim($row['ValuationDate']);
$product['MaturityDate']=trim($row['MaturityDate']);
$product['NoOfDays']=$this->convertToNeg($row['NoOfDays']);
$product['NominalAmount']=$this->convertToNeg($row['NominalAmount']);
$product['YieldBeforeTax']=$this->BlankToNull($row['YieldBeforeTax']);
$product['InterestEarn']=$this->convertToNeg($row['InterestEarn']);
$product['WithHoldingTax']=$this->convertToNeg($row['WithHoldingTax']);
$product['TotalSettlementAmount']=$this->convertToNeg($row['TotalSettlementAmount']);
$product['YieldAfterTax']=$this->BlankToNull($row['YieldAfterTax']);
$product['NoOfShare']=$this->convertToNeg($row['NoOfShare']);
$product['Comment']=trim($row['Comments']);
$product['LossProtectionAmount']=trim($row['LossProtectionAmount']);
$products[]=$product;
        }
        
    }
	else
	{
	$product='No Record product';
	$products[]=$product;
	}
	}else {
        return "Connection could not be established.\n";
        die(print_r(sqlsrv_errors(), true));
    }
    sqlsrv_close($conn);
        
        return $products;
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