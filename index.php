<html>
	<head>
		<title>AJAX Player</title>
	</head>
	<body>
		<?php
			include 'connection.php';

			if(!isset($_GET['room'])) {
				$cmd = 'SELECT * FROM `rooms`;';
				$result = mysqli_query($connect, $cmd);

				while($row = mysqli_fetch_array($result)) {
					echo '<a href="?room='.$row['id'].'">'.$row['name'].'</a>';
					echo '<br/>';
				}

				echo '<form action="add_room.php" method="get">';
				echo '<input type="text" name="name" placeholder="Room name" autofocus required>';
				echo '<input type="submit" value="Add">';
				echo '</form>';
			}else {
				$room_id = $_GET['room'];
				
				$cmd = 'SELECT `name` FROM `rooms` WHERE `id`='.$room_id.';';
				$result = mysqli_query($connect, $cmd);
				
				while($row = mysqli_fetch_array($result)) {
					$room_name = $row['name'];
				}

				echo '<h1>'.$room_name.'</h1>';

				echo '<form action="upload.php?room='.$room_id.'" method="post" enctype="multipart/form-data">';
				echo '<input type="file" name="song" autofocus required>';
				echo '<input type="submit" value="Upload">';
				echo '</form>';

				echo '<p>filename</p>';
				echo '<p>status</p>';

				echo '<a href="set_status.php?room='.$room_id.'">Play/Pause</a>';
				echo '<br/>';
				echo '<a href="index.php">Back</a>';
			}
		?>
	</body>
</html>
