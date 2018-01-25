<?php
	if(isset($_GET['name']) && !empty($_GET['name'])) {
		$room_name = $_GET['name'];

		$dir = 'rooms/' . $room_name;

		if(!file_exists($dir)) {
			mkdir($dir);
		
			header('location: set_status.php?room='.$room_name.'&status=empty');	
		}
	} 
	
	header('location: index.php');
?>
