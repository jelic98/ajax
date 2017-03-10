<?php
	$status = 'empty';
	
	if(isset($_GET['room'])) {
		$room_name = $_GET['room'];

		$filename = 'rooms/'.$room_name.'/status.txt';

		$file = fopen($filename, 'r');
		$status = fread($file, filesize($filename));
		fclose($file);
	}	

	echo $status;	
?>
