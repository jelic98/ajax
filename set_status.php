<?php
	if(isset($_GET['room']) && isset($_GET['status'])) {
		$room_name = $_GET['room'];
		$status = $_GET['status'];

		$filename = 'rooms/'.$room_name.'/status.txt';

		if($status == 'reset') {
			$status = 'change';	
		}elseif($status == 'rotate') {
			$status = file_get_contents($filename);

			if($status == 'play') {
				$status = 'pause';
			}elseif($status == 'pause' || $status == 'change') {
				$status = 'play';
			}
		}

		file_put_contents($filename, $status);
	
		echo file_get_contents($filename); 
	}
?>
