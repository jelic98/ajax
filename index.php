<html>
	<head>
		<title>AJAX Player</title>
	</head>
	<body onload="update()">
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

				echo '<p id="status">empty</p>';

				echo '<button type="button" onclick="setStatus()">Play/Pause</button>';
				echo '<br/>';
				echo '<a href="index.php">Back</a>';
			}

			mysqli_close($connect);
		?>
		<script>
			var audio = new Audio("<?php echo $room_name; ?>/song.mp3");

			function update() {
				change();
				setInterval(getStatus, 50);
			}

			function change() {
				audio = new Audio("<?php echo $room_name; ?>/song.mp3");
			}

			function play() {
				audio.play();
			}

			function pause() {
				audio.pause();	
			}
		
			function setStatus() {
				var xhttp = new XMLHttpRequest();
				xhttp.open("GET", "set_status.php?room=<?php echo $room_id; ?>", true);
				xhttp.send();
			}

			function getStatus() {
				var xhttp = new XMLHttpRequest();

				xhttp.onreadystatechange = function() {
					if(this.readyState == 4 && this.status == 200) {
						switch(this.responseText) {
							case "play":
								play();
								break;
							case "pause":
								pause();
								break;
							case "change":
								change();
								break;
						}

						document.getElementById("status").innerHTML = this.responseText;
					}
				};
										    
				xhttp.open("GET", "get_status.php?room=<?php echo $room_id; ?>", true);
				xhttp.send();
			}
		</script>
	</body>
</html>
