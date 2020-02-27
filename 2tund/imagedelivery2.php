<?php
    $picsDir = "../../pics/";
	$pic = $_GET["pic"];
	//$pic="IMG_0177.JPG";
	readfile($picsDir .$pic);
?>