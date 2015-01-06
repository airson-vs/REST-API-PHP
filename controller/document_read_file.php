<?php

$targetDir = dirname( realpath('./') ) . DIRECTORY_SEPARATOR . 'upload_temp' . DIRECTORY_SEPARATOR . 'documents' .DIRECTORY_SEPARATOR;

function human_filesize($bytes, $decimals = 2) {
	$sz = 'BKMGTP';
	$factor = floor((strlen($bytes) - 1) / 3);
	return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
}

$files = array();
if ($handle = opendir($targetDir)) {
	while (false !== ($file = readdir($handle))) {
		if ($file != "." && $file != "..") {
			$info = null;
			$fsize = filesize ( $targetDir . $file );
						
			array_push($files, array(
				'name'=>$file,
				'size'=>human_filesize($fsize)
			));
		}
	}
	closedir($handle);

	// sort
	//krsort($files);
}

echo json_encode($files);
