<?php
	$status = 'empty';
	
	if(isset($_GET['room'])) {
		$room_name = $_GET['room'];

		$filename = 'rooms/'.$room_name.'/status.txt';
		
		$status = file_get_contents($filename); 
	}	

	echo $status;	
?>
