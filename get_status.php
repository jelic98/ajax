<?php
	$status = 'empty';
	
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
		
		mysqli_close($connect);
	}	

	echo $status;	
?>
