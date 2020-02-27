<?php
    $picsDir = "../../pics/";
	$pic = $_GET["pic"];
	$fileInfo = getimagesize($picsDir .$pic);
	if($fileInfo["mime"] == "image/jpeg"){
		$image = imagecreatefromjpeg($picsDir .$pic);
		header("Content-Type: image/jpeg");
		imagejpeg($image);
	} elseif ($fileInfo["mime"] == "image/png"){
		imagecreatefrompng($picsDir .$pic);
		header("Content-Type: image/png");
		imagepng($image);
	} 
	//readfile($picsDir .$pic);
	imagedestroy($image);
?>