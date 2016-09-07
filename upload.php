<?php
	session_start();
	
	if(isset($_GET['room']) && $_POST['_token'] == $_SESSION['_token']) {
		$status_file = fopen($room_name.'/status.txt', 'w');
		$status = 'pause';
		fwrite($status_file, $status);
		fclose($status_file);
		
		include 'connection.php';

		$room_id = $_GET['room'];
		
		$cmd = 'SELECT `name` FROM `rooms` WHERE `id`='.$room_id.';';
		$result = mysqli_query($connect, $cmd);

		while($row = mysqli_fetch_array($result)) {
			$room_name = $row['name'];
		}
		
		unlink($room_name.'/song.mp3');
		move_uploaded_file($_FILES['song']['tmp_name'], $room_name.'/song.mp3');
		
		mysqli_close($connect);

		$status_file = fopen($room_name.'/status.txt', 'w');
		$status = 'change';
		fwrite($status_file, $status);
		fclose($status_file);
			
		header('location: index.php?room='.$room_id);
	}else {
		header('location: index.php');	
	}
?>
