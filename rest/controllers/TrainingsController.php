<?php

/**
 * 
 * @package api-framework
 * @author  Jugal Kishor <jugal.lalriya@gmail.com>
 */
class TrainingsController extends AbstractController {
    /**
     * GET method.
     * 
     * @param  Request $request
     * @return string
     */
    public function get($request) {
    
        $lang_id = $request->url_elements[1];
        $trainings = $this->readTrainings($lang_id);
        switch (count($request->url_elements)) {
            case 2:
                return $trainings;
                break;           
            case 3:
                return $trainings;
                break;
        }
    }

    /**
     * Read trainings.
     *
     * @return array
     */
    protected function readTrainings($lang_id) {
        $trainings = null;
include 'config.php';
$conn = mssql_jp_connect();

    if ($conn) {
    if ($lang_id == 'EN') {
        $table_name = "job_a_05_training_en";
    } else {
        $table_name = "job_a_05_training_th";
    }
     $db_array_col = array(
     "id", 
     "start_date", 
     "start_time_24hrs", 
     "end_date", 
     "end_time_24hrs", 
     "location", 
     "capacity", 
     "fee",
     "short_course_name", 
     "course_name", 
     "category_name", 
     "course_code", 
     "objective", 
     "course_outline", 
     "course_speaker", 
     "course_level",
     "course_language", 
     "course_status", 
     "keywords", 
     "remarks"
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
        $training['id']=$row['id'];
        $training['start_date']=$row['start_date'];
        $training['start_time_24hrs']=$row['start_time_24hrs'];
        $training['end_date']=$row['end_date'];
        $training['end_time_24hrs']=$row['end_time_24hrs'];
        $training['location']=$row['location'];
        $training['capacity']=floatval(trim($row['capacity']));
        $training['fee']=$row['fee'];
        $training['short_course_name']=$row['short_course_name'];
        $training['course_name']=$row['course_name'];
        $training['category_name']=$row['category_name'];
        $training['course_code']=$row['course_code'];
        $training['objective']=$row['objective'];
        $training['course_outline']=$row['course_outline'];
        $training['course_speaker']=$row['course_speaker'];
        $training['course_level']=$row['course_level'];
        $training['course_language']=$row['course_language'];
        $training['course_status']=$row['course_status'];
        $training['keywords']=$row['keywords'];
        $training['remarks']=$row['remarks'];
        $trainings[]=$training;
        
        }
        
    } 
	}else {
        return "Connection could not be established.\n";
        die(print_r(sqlsrv_errors(), true));
    }
    sqlsrv_close($conn);
        
        return $trainings;
    }

}
?>