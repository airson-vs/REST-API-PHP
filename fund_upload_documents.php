<?php require('partials/section-header.php'); ?> 
			
<div class="row">
	<?php require('partials/nav-sidebar.php'); ?> 
	
	<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="table-content">
		<h1>Fund &gt; Upload Documents</h1>

		<div id="dbsv-uploader">
			<p>Your browser doesn't have Flash, Silverlight or HTML5 support. xxxxx</p>
		</div>
		
		<h4>File list <a class="btn btn-info" role="button" id="b-reload">Reload</a></h4>
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<!--
					<th width="40"></th>
					-->
					<th width="50">#</th>
					<th>File name</th>
					<th width="120">Size</th>
					<th width="150"></th>
				</tr>
			</thead>
			<tbody id="file-list-container">
			</tbody>
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
			uploadContainer.pluploadQueue({
		        // General settings
		        runtimes : 'html5,flash,silverlight,html4',
		        url : "controller/document_upload.php",
		         
		        chunk_size : '1mb',
		        dragdrop: true,
				multiple_queues: true,
		         
		        filters : {
					// Maximum file size
					//max_file_size : '10mb',
					// Specify what files to browse for
					mime_types: [
						{title : "Image files", extensions : "jpg,gif,png"},
						{title : "Zip files", extensions : "zip"}
					]
		        },
		
		        // Flash settings
				flash_swf_url : 'assets/vendors/plupload/Moxie.swf',
		     
		        // Silverlight settings
				silverlight_xap_url : 'assets/vendors/plupload/Moxie.xap',
				
				init: {
		            FileUploaded: function(up, file, info) {
		                loadFileList();
            		}
				}
		    });
		};
		
		// Load file list
		var fileListContainer = $('#file-list-container');
		var loadFileList = function(cb){
			fileListContainer.empty();
			var html = [];
			$.post('controller/document_read_file.php', null, function(res){
				for(var i=0;i<res.length;i++){
					var o = res[i];
					html.push([
						'<tr>',
							//'<td align="center"><input type="checkbox" class="chk-select" /></td>',
							'<td>'+(i+1)+'</td>',
							'<td>'+o.name+'</td>',
							'<td>'+o.size+'</td>',
							'<td align="center">',
								'<input type="hidden" name="file-name" value="'+o.name+'" />',
								'<a class="btn btn-danger b-delete" role="button">Delete</a>',
								'<a class="btn btn-success b-delete-ok hidden" role="button">OK</a>&nbsp;',
								'<a class="btn btn-default b-delete-cancel hidden" role="button">Cancel</a>',
							'</td>',
						'</tr>'
					].join(''));
				}
				fileListContainer.html(html.join(''));
				
				// Bind delete single event
				bindDeleteSingleEvent();
				
				if(typeof(cb)=='function')
					cb();
			}, 'json');
		};
		loadFileList();
		
		// Delete file func
		var deleteFile = function(fileName, cb){
			$.post('controller/document_delete.php', {
				name: fileName
			}, function(res){
				if(typeof(cb)=='function'){
					cb();
				}
			}, 'json');
		};
		
		// Bind reload button event
		var bReload = $('#b-reload');
		$('#b-reload').click(function(e){
			e.preventDefault();
			bReload.addClass('disabled');
			loadFileList(function(){
				bReload.removeClass('disabled');
			});
		});
		
		// Function for bind delete buttons event
		var bindDeleteSingleEvent = function(){
			var bDelete = $('.b-delete', fileListContainer);
			var bDeleteOK = $('.b-delete-ok', fileListContainer);
			var bDeleteCancel = $('.b-delete-cancel', fileListContainer);
			bDelete.click(function(e){
				e.preventDefault();
				var el = $(this);
				var elParent = el.parent();

				el.addClass('hidden');
				$('.b-delete-ok', elParent).removeClass('hidden');
				$('.b-delete-cancel', elParent).removeClass('hidden');
			});
			
			bDeleteOK.click(function(e){
				e.preventDefault();
				var el = $(this);
				var elParent = el.parent();
				
				el.addClass('disabled');
				$('.b-delete-cancel', elParent).addClass('disabled');
				
				var fileName = $('input[name=file-name]', elParent).val();
				deleteFile(fileName, function(){
					el.closest('tr').remove();
				});

				//el.addClass('hidden');
				//$('.b-delete-ok', elParent).addClass('hidden');
				//$('.b-delete', elParent).removeClass('hidden');
			});
			
			bDeleteCancel.click(function(e){
				e.preventDefault();
				var el = $(this);
				var elParent = el.parent();

				el.addClass('hidden');
				$('.b-delete-ok', elParent).addClass('hidden');
				$('.b-delete', elParent).removeClass('hidden');
			});
		};

	});
</script>

<?php require('partials/section-footer.php'); ?> 