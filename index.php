<?php
	session_start();
?>
<html>
<head>
	<title>AJAX Player</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body onload="update()">
	<div class="center">
	<?php
		$_SESSION['_token'] = bin2hex(openssl_random_pseudo_bytes(16));

		if(!isset($_GET['room'])) {
			echo '<h1>Lobby</h1>';

			$files = scandir('rooms/');

			foreach($files as $file) {
				if($file == '.' || $file == '..') {
					continue;
				}

				echo '<a class="item" href="index.php?room='.$file.'">'.$file.'</a>';
				echo '<br/>';
			}

			echo '<form action="add_room.php" method="get">';
			echo '<input type="text" name="name" placeholder="Room name" required>';
			echo '<br/>';
			echo '<input type="submit" value="+">';
			echo '</form>';
		}else {
			$room_name = $_GET['room'];
			
			echo '<h1>'.$room_name.'</h1>';

			echo '<label class="myLabel">';
			echo '<input type="file" id="file" name="song" required/>';
			echo '<span>Upload</span>';
			echo '</label>';
			echo '<input type="submit" id="submit" value="&#8593;">';
			
			echo '<div id="progress_container">';
			echo '<div id="progress_bar"></div>';
			echo '</div>';

			echo '<p id="status">No track</p>';
			
			echo '<a class="button" href="index.php">&#8592;</a>';
			echo '<a id="button" class="button" onclick="setStatus(\'rotate\')">&#9658;</a>';
			echo '<a class="button" onclick="setStatus(\'reset\')"><b>R</b></a>';	
		}
	?>
	</div>
	<?php
		if(isset($_GET['room'])) {
			echo '<div id="access" onclick="access(this)">Click to enter</div>';
		}
	?>
	<audio id="player"></audio>
	<script>
		var entered = false;
		var submit = document.getElementById("submit");
		var file = document.getElementById("file");
		var progress = document.getElementById("progress_bar");

		function toggleProgressBarVisibility() {
			var bar = document.getElementById("progress_container");
		
			if(bar.style.display) {
				bar.style.display = 'none';
			}else {
				bar.style.display = 'block';	
			}
		}

		submit.onclick = function() {
			if(file.files.length == 0) {
				return;	
			}

			var data = addFormData();
			var request = new XMLHttpRequest();

			request.upload.addEventListener('progress', function(e) {
		    	var percentage = Math.ceil(e.loaded / e.total * 100) + "%"; 
								
				progress.style.width = percentage;
				progress.innerHTML = percentage;	
																			
				if(percentage == '100%') {
					toggleProgressBarVisibility();	
				}
			}, false);

			request.open('POST', 'upload.php?room=<?php echo $room_name; ?>');
			request.send(data);	

			toggleProgressBarVisibility();
		}

		function toggleProgressBarVisibility() {
			var bar = document.getElementById("progress_container");
								
			if(bar.style.display) {
				bar.style.display = 'none';
			}else {
				bar.style.display = 'block';	
			}
		}

		function addFormData() {
			var data = new FormData();
			data.append("file", file.files[0]);
			data.append("_token", "<?php echo $_SESSION['_token']?>");
			return data;
		}

		var audio = document.getElementById('player');

		function update() {
			setInterval(getStatus, 250);
		}

		function access(e) {
			entered = true;
			e.style.visibility = 'hidden';
			play();
			change();	
		}

		function change() {
			audio.src = '<?php echo "rooms/".$room_name; ?>/song.mp3';
		}

		function play() {
			audio.play();
		}

		function pause() {
			audio.pause();	
		}
	
		function setStatus(statusVal) {
			var xhttp = new XMLHttpRequest();
			xhttp.open("GET", "set_status.php?room=<?php echo $room_name; ?>&status=" + statusVal, true);
			xhttp.send();
			
			return false;
		}

		function getStatus() {
			if(!entered) {
				return;
			}

			var xhttp = new XMLHttpRequest();

			xhttp.onreadystatechange = function() {
				if(this.readyState == 4 && this.status == 200) {
					var element = document.getElementById("status");
					var button = document.getElementById("button");			

					switch(this.responseText) {
						case "play":
							play();
							button.innerHTML = "&#10074;&#10074;";
							element.innerHTML = "Playing";
							break;
						case "pause":
							pause();
							button.innerHTML = "&#9658;";
							element.innerHTML = "Paused";
							break;
						case "change":
							change();
							button.innerHTML = "&#9658;";
							element.innerHTML = "Ready";
							break;
						case "empty":
							button.innerHTML = "&#9658;";
							element.innerHTML = "No track";
							break;
					}
				}
			};
										
			xhttp.open("GET", "get_status.php?room=<?php echo $room_name; ?>", true);
			xhttp.send();
			}
		</script>
	</body>
</html>
