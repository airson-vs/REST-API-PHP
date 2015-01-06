<?php

$targetDir = dirname( realpath('./') ) . DIRECTORY_SEPARATOR . 'upload_temp' . DIRECTORY_SEPARATOR . 'documents' .DIRECTORY_SEPARATOR;

if(isset($_POST['name'])){
	$flgDelete = unlink($targetDir.$_POST['name']);
	
	echo json_encode(array('success'=>TRUE));
}else{
	echo json_encode(array('success'=>FALSE));
}