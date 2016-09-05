<?php
	include 'connection.php';

	if(isset($_GET['name'])) {
		$name = $_GET['name'];

		$cmd = "INSERT INTO `rooms` (`name`) VALUES ('".$name."');";
		mysqli_query($connect, $cmd);
	
		mkdir($name);

		$file = fopen($name.'/status.txt', 'w');
		$status = 'empty';
		fwrite($file, $status);
		fclose($file);
	} 

	header('location: index.php');	
?>
