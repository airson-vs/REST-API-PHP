<?php
require('partials/section-header.php');

/* ==========================================================================
  Db connectivity
  ========================================================================== */
include 'config.php';
$conn1 = mssql_jp_connect();
?> 

<div class="row">
    <?php require('partials/nav-sidebar.php'); ?> 

    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="table-content">
        <h1>Training Center &gt; English</h1>

        <div id="dbsv-uploader">
            <p>Your browser doesn't have Flash, Silverlight or HTML5 support. xxxxx</p>
        </div>

        <h4>Result 
            <span class="btn btn-success btn-xs" id="process_btn" style="float:right;margin-bottom:10px;">Process</span>
            <!-- /.process button to fetch the data -->
        </h4>

        <div style="clear:both;"></div>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>

                    <?php
                    $array_col = array("S.No.", "Start Date", "Start Time - 24 Hrs", "End Date", "End Time -24 Hrs", "Location", "Capacity", "Fee", "Short Course Name",
                        "Course Name", "Category Name", "Course Code", "Objective", "Course Outline", "Course Speaker", "Course Level", "Course Language", "Course Status", "Keywords", "Remarks");

                    for ($i = 0; $i < count($array_col); $i++):
                        ?>
                        <th> <?= $array_col[$i] ?></th>
                    <?php endfor; ?>
                </tr>
            </thead>
            <tbody id="refersh_data"><!-- /. data table -->
                <?php
                $db_array_col = array("id", "start_date", "start_time_24hrs", "end_date", "end_time_24hrs", "location", "capacity", "fee",
                    "short_course_name", "course_name", "category_name", "course_code", "objective", "course_outline", "course_speaker", "course_level",
                    "course_language", "course_status", "keywords", "remarks");

                $tsql = "SELECT * FROM job_a_05_training_en"; //order by id DESC

                $stmt = sqlsrv_query($conn1, $tsql);
                if ($stmt === false) {
                    echo "Error in query preparation/execution.\n";
                    die(print_r(sqlsrv_errors(), true));
                }

                $rows = sqlsrv_has_rows($stmt);

                if ($rows === true) {
                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                        ?>
                        <tr>
                            <?php for ($j = 0; $j < count($array_col); $j++): ?>
                                <td><?= $row[$db_array_col[$j]] ?></td>
                            <?php endfor; ?>
                        </tr>
                        <?php
                    }
                }
                else {
                    ?>
                    <tr> <td colspan="<?= count($array_col); ?>"> No Data</td> </tr>
                    <?php
                }
                ?>   
            </tbody><!-- /. data table end-->
        </table>
    </div>

</div>

<script type="text/javascript" src="assets/vendors/plupload/plupload.full.min.js"></script>
<script type="text/javascript" src="assets/vendors/plupload/jquery.plupload.queue/jquery.plupload.queue.min.js" charset="UTF-8"></script>
<link type="text/css" rel="stylesheet" href="assets/vendors/plupload/jquery.plupload.queue/css/jquery.plupload.queue.css" media="screen" />
<script type="text/javascript">
    // Initialize the widget when the DOM is ready
    $(function() {
        var uploadContainer = $("#dbsv-uploader");
		
        if(uploadContainer && uploadContainer.length>0){
            var a=uploadContainer.pluploadQueue({
                        // General settings
                        runtimes : 'html5,flash,silverlight,html4',
                        url : "controller/document_upload.php?action=training_center&language=english",
                        chunk_size : '1mb',
                        dragdrop: true,
                        multiple_queues: true,
                        filters : {
                    // Maximum file size
                    //max_file_size : '10mb',
                    // Specify what files to browse for
                    mime_types: [
                        {title : "Excel files", extensions : "xls,xlsx"}
                    ]
                        },
		
                        // Flash settings
                flash_swf_url : 'assets/vendors/plupload/Moxie.swf',
                     
                        // Silverlight settings
                silverlight_xap_url : 'assets/vendors/plupload/Moxie.xap'
				
                });
            console.log(a);
        };
    });
    
    
    /* ==========================================================================
        Data Process Script
  ========================================================================== */
    $(document).ready(function(){
        $('#process_btn').click(function(){
            var ajaxurl= "load.php";
            var data = {
                "action": 'training_center',
                "language": 'english'
            };  
                                                                                                                                                                                                                                                                                                                                                                                                                                          
            $('#waiting_process').css( "display","block" );
            $('#waiting_process_text').css( "display","block" );
            $('#waiting_process_image').css( "display","block" );
                                                                                                                                                                                                                                                                                                                                                                                                                                            
            $.post( ajaxurl, data,
            function( response ) { 
                            
                $('#refersh_data').empty();
                $('#waiting_process').css( "display","none" );
                $('#waiting_process_text').css( "display","none" );
                $('#waiting_process_image').css( "display","none" ); 
                $('#refersh_data').html(response);    
               
            });
            
        })
    });
    
    /* ==========================================================================
      End of  Data Process Script
  ========================================================================== */
    
</script>

<?php require('partials/section-footer.php'); ?> 