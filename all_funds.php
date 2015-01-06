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
        <h1>Fund &gt; All Funds</h1>
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

            </thead>
            <tbody id="refersh_data"><!-- /. data table -->
                 
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
                        url : "controller/document_upload.php?action=all_funds",
                chunk_size : '1mb',
                        dragdrop: true,
                multiple_queues: true,
                        filters : {
                    // Maximum file size
                    //max_file_size : '10mb',
                    // Specify what files to browse for
                    mime_types: [
                        {title : "Excel files", extensions : "xlsx,xls"}
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
                "action": 'all_funds'
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