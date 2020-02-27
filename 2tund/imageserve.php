<?php
	header("Content-Type: image/jpeg");
	/* $picsDir = "../../pics/";
	$pic="IMG_9532.JPG";
	$image = imagecreatefromjpeg($picsDir .$file);
	imagejpeg($image); */
	readfile($picsDir .$file);	
?>