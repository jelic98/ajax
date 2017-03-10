<?php
	if(isset($_GET['name']) && !empty($_GET['name'])) {
		$room_name = $_GET['name'];

		if(!file_exists($dir)) {
			mkdir('rooms/'.$room_name);
		
			header('location: set_status.php?room='.$room_name.'&status=empty');	
		}
	} 
	
	header('location: index.php');
?>
