<?php
	if(isset($_GET['room'])) {
		include 'connection.php';
	
		$room_id = $_GET['room'];
		
		$cmd = 'SELECT `name` FROM `rooms` WHERE `id`='.$room_id.';';
		$result = mysqli_query($connect, $cmd);

		while($row = mysqli_fetch_array($result)) {
			$room_name = $row['name'];
		}
		
		$file = fopen($room_name.'/status.txt', 'r');	
		$status = fread($file, filesize($room_name.'/status.txt'));
		fclose($file);
		
		if($status == 'play') {
			$status = 'pause';
		}elseif($status == 'pause') {
			$status = 'play';
		}

		$file = fopen($room_name.'/status.txt', 'w');
		fwrite($file, $status);
		fclose($file);

		header('location: index.php?room='.$room_id);
	}else {
		header('location: index.php');	
	}
?>
