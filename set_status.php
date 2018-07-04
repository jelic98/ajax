<?php
 	require('autoload.php');

	if(isset($_GET['room']) && isset($_GET['status'])) {
		$room_name = strip($_GET['room']);
		$status = strip($_GET['status']);

		$filename = 'rooms/'.$room_name.'/status.txt';

		writeToFile($filename, $status);
	}
?>	
