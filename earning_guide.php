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
        <h1>Earning Guide</h1>

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
                    $array_col = array("S.No.", "Parent", "Child", "Market Cap.(Btm)", "Price (Bt) 2-sep-2014", "Target Price (Bt)", "Percent Upside", "Rcmd",
                        "Net Profit Btm 11a", "Net Profit Btm 12a", "Net Profit Btm 13a", "Net Profit Btm 14f", "Net Profit Btm 15f", "Net Profit Gth Prcnt 12a", "Net Profit Gth Prcnt 13f", "Net Profit Gth Prcnt 14f",
                        "Eps Bt 11a", "Eps Bt 12a", "Eps Bt 13a", "Eps Bt 14f", "Eps Bt 15f", "Eps Gth Percent 12a", "Eps Gth Percent 13a", "Eps Gth Percent 14f", "Eps Gth Percent 15f", "P/E (x) 11a", "P/E (x) 12a", "P/E (x) 13a", "P/E (x) 14f"
                        , "P/E (x) 15f", "Peg 13a", "Peg 14f", "Peg 15f", "Bps Bt 12a", "Bps Bt 13f", "Bps Bt 14f", "Bps Bt 15f", "P/BV X 12a", "P/BV X 13a"
                        , "P/BV X 14f", "P/BV X 15f", "Dps Bt 12a", "Dps Bt 13a", "Dps Bt 14f", "Dps Bt 15f", "Div Yield Percent 12a", "Div Yield Percent 13a", "Div Yield Percent 14f", "Div Yield Percent 15f"
                        , "Net Debt Equity X 13a", "Roe Percent 13a", "Set50", "Set100");

                    for ($i = 0; $i < count($array_col); $i++):
                        ?>
                        <th> <?= $array_col[$i] ?></th>
                    <?php endfor; ?>
                </tr>
            </thead>
            <tbody id="refersh_data"><!-- /. data table -->
                <?php
                $db_array_col = array("id", "parent", "child", "market_cap_btm", "price_bt_2_sep", "target_price_bt", "percent_upside", "rcmd",
                    "net_profit_btm_11a", "net_profit_btm_12a", "net_profit_btm_13a", "net_profit_btm_14f", "net_profit_btm_15f", "net_profit_gth_prcnt_12a", "net_profit_gth_prcnt_13f", "net_profit_gth_prcnt_14f",
                    "eps_bt_11a", "eps_bt_12a", "eps_bt_13a", "eps_bt_14f", "eps_bt_15f", "eps_gth_percent_12a", "eps_gth_percent_13a", "eps_gth_percent_14f", "eps_gth_percent_15f", "pe_x_11a", "pe_x_12a", "pe_x_13a", "pe_x_14f"
                    , "pe_x_15f", "peg_13a", "peg_14f", "peg_15f", "bps_bt_12a", "bps_bt_13f", "bps_bt_14f", "bps_bt_15f", "pbv_x_12a", "pbv_x_13a"
                    , "pbv_x_14f", "pbv_x_15f", "dps_bt_12a", "dps_bt_13a", "dps_bt_14f", "dps_bt_15f", "div_yield_percent_12a", "div_yield_percent_13a", "div_yield_percent_14f", "div_yield_percent_15f"
                    , "net_debt_equity_x_13a", "roe_percent_13a",  "set50","set100"
                );

                $tsql = "SELECT * FROM job_a_04_earning_guide"; //order by id DESC

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
                        url : "controller/document_upload.php?action=earning_guide",
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
                "action": 'earning_guide'
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