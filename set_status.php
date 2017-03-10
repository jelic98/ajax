<?php
	if(isset($_GET['room']) && isset($_GET['status'])) {
		$room_name = $_GET['room'];
		$status = $_GET['status'];

		$filename = 'rooms/'.$room_name.'/status.txt';

		if($status == 'reset') {
			$status = 'change';	
		}elseif($status == 'rotate') {
			$file = fopen($filename, 'r');	
			$status = fread($file, filesize($filename));
			fclose($file);

			if($status == 'play') {
				$status = 'pause';
			}elseif($status == 'pause' || $status == 'change') {
				$status = 'play';
			}
		}

		$file = fopen($filename, 'w');
		fwrite($file, $status);
		fclose($file);
	}

	header('location: index.php');
?>
