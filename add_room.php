<?php
	if(isset($_GET['name'])) {
		include 'connection.php';

		$name = $_GET['name'];

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
