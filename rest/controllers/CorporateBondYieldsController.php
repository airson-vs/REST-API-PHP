<?php

/**
 * 
 * @package api-framework
 * @author  Jugal Kishor <jugal.lalriya@gmail.com>
 */
class CorporateBondYieldsController extends AbstractController {
    /**
     * GET method.
     * 
     * @param  Request $request
     * @return string
     */
    public function get($request) {
    
        $corporateBondYields = $this->readCorporateBondYields();
        switch (count($request->url_elements)) {
            case 1:
                return $corporateBondYields;
                break;           
            case 3:
                return $corporateBondYields;
                break;
        }
    }

    /**
     * Read corporateBondYields.
     *
     * @return array
     */
    protected function readCorporateBondYields() {
        $corporateBondYields = null;
$corporateBondYield_html = '';
include 'config.php';
$conn = mssql_jp_connect();
$table_name = "job_a_07_corporate_bond_yield";
    if ($conn) {
$db_array_col = array("id", "ttm", "aaa", "aa_plus", "aa_minus", "aa", "a_plus", "a_minus", "a", "bbb_plus","bbb");

    $tsql = "SELECT * FROM $table_name";//order by id DESC

    $stmt = sqlsrv_query($conn, $tsql);
    if ($stmt === false) {
        echo "Error in query preparation/execution.\n";
        die(print_r(sqlsrv_errors(), true));
    }

    $rows = sqlsrv_has_rows($stmt);
$corporateBondYield_html='<table><thead>
                <tr>
		<td >S. No.</td> 
		<td >TTM</td>
		<td >AAA</td>
		<td >AA+</td>
		<td >AA-</td>		
		<td >AA</td>
		<td >A+</td>
		<td >A-</td>
		<td >A</td>
		<td >BBB+</td>
		<td >BBB</td> 
		</tr>
            </thead><tbody id="refersh_data">';
if ($rows === true) {
                   while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                        $corporateBondYield_html=$corporateBondYield_html.'<tr>';
                        $corporateBondYield_html=$corporateBondYield_html.'<td>'.$row['id'].'</td>';
                        $corporateBondYield_html=$corporateBondYield_html.'<td>'.$row['ttm'].'</td>';
			$corporateBondYield_html=$corporateBondYield_html.'<td>'.$row['aaa'].'</td>';
			$corporateBondYield_html=$corporateBondYield_html.'<td>'.$row['aa_plus'].'</td>';
			$corporateBondYield_html=$corporateBondYield_html.'<td>'.$row['aa_minus'].'</td>';
			$corporateBondYield_html=$corporateBondYield_html.'<td>'.$row['aa'].'</td>';
			$corporateBondYield_html=$corporateBondYield_html.'<td>'.$row['a_plus'].'</td>';
			$corporateBondYield_html=$corporateBondYield_html.'<td>'.$row['a_minus'].'</td>';
			$corporateBondYield_html=$corporateBondYield_html.'<td>'.$row['a'].'</td>';
		        $corporateBondYield_html=$corporateBondYield_html.'<td>'.$row['bbb_plus'].'</td>';
			$corporateBondYield_html=$corporateBondYield_html.'<td>'.$row['bbb'].'</td>';
                        $corporateBondYield_html=$corporateBondYield_html.'</tr>';                       
                    }
                }
                else {
                    
                    $corporateBondYield_html=$corporateBondYield_html.'<tr><td colspan="8"> No Data</td></tr>';
                    
                }
                 
           
	}else {
        return "Connection could not be established.\n";
        die(print_r(sqlsrv_errors(), true));
    }
    $corporateBondYields=$corporateBondYield_html.'</tbody></table>';
    sqlsrv_close($conn);
        
        return $corporateBondYields;
    }

}
?>