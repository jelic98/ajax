<?php
	session_start();

 	require('autoload.php');

	if(isset($_GET['room']) && $_POST['_token'] == $_SESSION['_token']) {
		$room_name = strip($_GET['room']);
		$dir = 'rooms/'.$room_name;
		$file_extension = strtolower(strrchr($_FILES['file']['name'], '.'));
	
		if($file_extension == '.mp3' && $_FILES['file']['size'] < 20623360) {
			unlink($dir.'/song.mp3');
			move_uploaded_file($_FILES['file']['tmp_name'], $dir.'/song.mp3');
	
			header('location: set_status.php?room='.$room_name.'&status=change');
		}
	}
?>
