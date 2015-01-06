<?php

/**
 * 
 * @package api-framework
 * @author  Jugal Kishor <jugal.lalriya@gmail.com>
 */
class FundRecsController extends AbstractController {
    /**
     * GET method.
     * 
     * @param  Request $request
     * @return string
     */
    public function get($request) {
    
        $foundRecs = $this->readFoundRecs();
        switch (count($request->url_elements)) {
            case 1:
                return $foundRecs;
                break;           
            case 3:
                return $foundRecs;
                break;
        }
    }

    /**
     * Read foundRecs.
     *
     * @return array
    
    protected function readFoundRecs() {
        $foundRecs = null;
include 'config.php';
$conn = mssql_jp_connect();
    if ($conn) {
        $table_name = "job_a_03_recommendation";
     $db_array_col = array(
     "id", 
     "recommend_service", 
     "amc", 
     "fund", 
     "note"
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
        $foundRec['id']=$row['id'];
        $foundRec['recommend_service']=$row['recommend_service'];
        $foundRec['amc']=$row['amc'];
        $foundRec['fund']=$row['fund'];
        $foundRec['note']=$row['note'];
        $foundRecs[]=$foundRec;
        
        }
        
    }
	else
	{
	$foundRec='No Record found';
	$foundRecs[]=$foundRec;
	}
	}else {
        return "Connection could not be established.\n";
        die(print_r(sqlsrv_errors(), true));
    }
    sqlsrv_close($conn);
        
        return $foundRecs;
    } */
    protected function readFoundRecs() {
	$foundRecs = null;
	$foundRecs_html = '';
include 'config.php';
$conn = mssql_jp_connect();
	$table_name = "job_a_03_recommendation";
	if ($conn) {
	$db_array_col = array("excel_data");
	$tsql = "SELECT * FROM $table_name";//order by id DESC
	$stmt = sqlsrv_query($conn, $tsql);
	    if ($stmt === false) {
	        echo "Error in query preparation/execution.\n";
	        die(print_r(sqlsrv_errors(), true));
	    }
		$rows = sqlsrv_has_rows($stmt);
		if ($rows === true) {
                  while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                            $foundRecs_html=$row['excel_data'];
                    }
                }
                else {
                    $foundRecs_html='No Data';
                }
	}else {
        return "Connection could not be established.\n";
        die(print_r(sqlsrv_errors(), true));
    	}
	    sqlsrv_close($conn);
        $foundRecs=$foundRecs_html;
        return $foundRecs;
	}

}
?>