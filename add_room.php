<?php
	session_start();

	if(isset($_POST['name']) && !empty($_POST['name']) && $_SESSION['_token'] == $_POST['_token']) {
		include 'connection.php';

		$name = $_POST['name'];

		$cmd = "INSERT INTO `rooms` (`name`) VALUES ('".$name."');";
		mysqli_query($connect, $cmd);
	
		mkdir($name);

		$file = fopen($name.'/status.txt', 'w');
		$status = 'empty';
		fwrite($file, $status);
		fclose($file);

		mysqli_close($connect);
	} 

	header('location: index.php');	
?>
