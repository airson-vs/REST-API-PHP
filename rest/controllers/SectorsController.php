<?php

/**
 * 
 * @package api-framework
 * @author  Jugal Kishor <jugal.lalriya@gmail.com>
 */
class SectorsController extends AbstractController {
    /**
     * GET method.
     * 
     * @param  Request $request
     * @return string
     */
    public function get($request) {
        $sectors = $this->readSectors();
//        print_r($request->url_elements);
        switch (count($request->url_elements)) {
            case 1:
                // print_r($sectors);
                return $sectors;
                break;
            case 2:
                $sector_id = $request->url_elements[1];
                return $sectors[$sector_id];
                break;
            case 3:
                return $sectors;
                break;
        }
    }

    /**
     * Read sectors.
     *
     * @return array
     */
    protected function readSectors() {
        $sectors = null;
include 'config.php';
$conn = mssql_jp_connect();

    if ($conn) {
    
    $tsql = "select parent,child from job_a_04_earning_guide order by parent";

    $stmt = sqlsrv_query($conn, $tsql);
    if ($stmt === false) {
        echo "Error in query preparation/execution.\n";
        die(print_r(sqlsrv_errors(), true));
    }

    $row = sqlsrv_has_rows($stmt);

    if ($row === true) {
    
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $data[] = $row;
    }
    $tmpP=$data[0]['parent'];
    $tmpC[]=$data[0]['child'];
        for($i=1;$i< count($data);$i++) 
        {
          if($tmpP==$data[$i]['parent'])
          {
          $tmpC[]=$data[$i]['child'];
          }
          else
          {
          
          $sectors['SectorID']=$tmpP;
          $sectors['StockIDs']=$tmpC;         
          $sector[]=$sectors;
          $tmpC=null;
          $tmpP=null;
          $tmpP=$data[$i]['parent'];
          $tmpC[]=$data[$i]['child'];
          
          
          }
          
        }
     }
	     $sectors['SectorID']=$tmpP;
          $sectors['StockIDs']=$tmpC;         
          $sector[]=$sectors;
                
            
        //  $sectors = unserialize(file_get_contents($this->sectors_file));

    } else {
        return "Connection could not be established.\n";
        die(print_r(sqlsrv_errors(), true));
    }
    sqlsrv_close($conn);
        
        return $sector;
    }
}
?>