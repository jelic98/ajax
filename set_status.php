<?php
	if(isset($_GET['room']) && isset($_GET['status'])) {
		include 'connection.php';
	
		$room_id = $_GET['room'];
		$status = $_GET['status'];
	
		$cmd = 'SELECT `name` FROM `rooms` WHERE `id`='.$room_id.';';
		$result = mysqli_query($connect, $cmd);

		while($row = mysqli_fetch_array($result)) {
			$room_name = $row['name'];
		}

		if($status == 'reset') {
			$status = 'change';	
		}elseif($status == 'switch') {
			$file = fopen($room_name.'/status.txt', 'r');	
			$status = fread($file, filesize($room_name.'/status.txt'));
			fclose($file);

			if($status == 'play') {
				$status = 'pause';
			}elseif($status == 'pause' || $status == 'change') {
				$status = 'play';
			}
		}

		$file = fopen($room_name.'/status.txt', 'w');
		fwrite($file, $status);
		fclose($file);
		
		mysqli_close($connect);
	}
?>
