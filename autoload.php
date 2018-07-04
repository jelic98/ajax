<?php
	function writeToFile($file, $content){
    	$fp = fopen($file, 'w');
    	fwrite($fp, $content);
  	  	fclose($fp);
  	  	chmod($file, 0777);
	}

	function readFromFile($file){
    	$fp = fopen($file, 'r');
    	$out = fgets($fp);
		fclose($fp);
  	  	chmod($file, 0777);
		return $out;
	}

	function strip($var) {
		return htmlspecialchars(strip_tags(trim($var)));
	}
?>
