<?php
	require('autoload.php');
	
	$status = 'empty';
	
	if(isset($_GET['room'])) {
		$room_name = strip($_GET['room']);

		$filename = 'rooms/' . $room_name . '/status.txt';
		
		$status = readFromFile($filename); 
	}	

	echo $status;	
?>
