<?php

/**
 * 
 * @package api-framework
 * @author  Jugal Kishor <jugal.lalriya@gmail.com>
 */
class SSFsController extends AbstractController {
    /**
     * GET method.
     * 
     * @param  Request $request
     * @return string
     */
    public function get($request) {
    
        $ssfs = $this->readSSFs();
        switch (count($request->url_elements)) {
            case 1:
                return $ssfs;
                break;           
            case 3:
                return $ssfs;
                break;
        }
    }

    /**
     * Read ssfs.
     *
     * @return array
     */
    protected function readSSFs() {
        $ssfs = null;
$ssf_html = '';
include 'config.php';
$conn = mssql_jp_connect();
$table_name = "job_a_01_ssf";
    if ($conn) {
$db_array_col = array(
    "id", "ssf", "mr_or_im", "mr_or_mm", "mr_or_fm", "mr_fm_im", "mr_fm_mm", "mr_fm_fm"
     );

    $tsql = "SELECT * FROM $table_name";//order by id DESC

    $stmt = sqlsrv_query($conn, $tsql);
    if ($stmt === false) {
        echo "Error in query preparation/execution.\n";
        die(print_r(sqlsrv_errors(), true));
    }

    $rows = sqlsrv_has_rows($stmt);
$rows = sqlsrv_has_rows($stmt);

$ssf_html='<table><thead>
                <tr><td rowspan="3" >S. No.</td> <td rowspan="3" >SSF</td><td colspan="6" align="center">Margin Requirement</td></tr>
                <tr>  <td colspan="3" align="center">Outright Position</td><td align="center" colspan="3">Spread Position</td></tr>
                <tr> <td  align="center">IM</td><td align="center">MM</td><td align="center">FM</td><td align="center">Im</td><td align="center">MM</td><td align="center">FM</td> </tr>
            </thead><tbody id="refersh_data">';
if ($rows === true) {
                   while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                      $ssf_html=$ssf_html.'<tr>';
                            $ssf_html=$ssf_html.'<td>'.$row['id'].'</td>';
                            $ssf_html=$ssf_html.'<td>'.$row['ssf'].'</td>';
							$ssf_html=$ssf_html.'<td>'.$row['mr_or_im'].'</td>';
							$ssf_html=$ssf_html.'<td>'.$row['mr_or_mm'].'</td>';
							$ssf_html=$ssf_html.'<td>'.$row['mr_or_fm'].'</td>';
							$ssf_html=$ssf_html.'<td>'.$row['mr_fm_im'].'</td>';
							$ssf_html=$ssf_html.'<td>'.$row['mr_fm_mm'].'</td>';
							$ssf_html=$ssf_html.'<td>'.$row['mr_fm_fm'].'</td>';
                        $ssf_html=$ssf_html.'</tr>';                       
                    }
                }
                else {
                    
                    $ssf_html=$ssf_html.'<tr><td colspan="8"> No Data</td></tr>';
                    
                }
                 
           
	}else {
        return "Connection could not be established.\n";
        die(print_r(sqlsrv_errors(), true));
    }
    $ssfs=$ssf_html.'</tbody></table>';
    sqlsrv_close($conn);
        
        return $ssfs;
    }

}
?>