<?php

/**
 * 
 * @package api-framework
 * @author  Jugal Kishor <jugal.lalriya@gmail.com>
 */
class UnderlyingsController extends AbstractController {
   /**
     * GET method.
     * 
     * @param  Request $request
     * @return string
     */
    public function get($request) {
    
        $underlayings = $this->readUnderlayings();
        switch (count($request->url_elements)) {
            case 1:
                return $underlayings;
                break;           
            case 3:
                return $underlayings;
                break;
        }
    }

    /**
     * Read underlayings.
     *
     * @return array
     */
protected function readUnderlayings() {
	$underlayings = null;
	$underlaying_html = '';
include 'config.php';
$conn = mssql_jp_connect();
	$table_name = "job_a_01_underlying";
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
                            $underlaying_html=$row['excel_data'];
                    }
                }
                else {
                    $underlaying_html='No Data';
                }
	}else {
        return "Connection could not be established.\n";
        die(print_r(sqlsrv_errors(), true));
    	}
	    sqlsrv_close($conn);
        $underlayings=$underlaying_html;
        return $underlayings;
	}
}
?>