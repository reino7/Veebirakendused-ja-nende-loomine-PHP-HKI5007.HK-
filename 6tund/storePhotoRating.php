<?php
	require("classes/Session.class.php");
	SessionManager::sessionStart("vr20", 0, "/~reino.ristissaar/", "tigu.hk.tlu.ee");
	
	$id = $_REQUEST["photoid"];
	$rating = $_REQUEST["rating"];
	
	require("db/configuration.php");
	
	$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUserName"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $conn->prepare("INSERT INTO vr20_photoratings (photoid, userid, rating) VALUES(?,?,?)");
	$stmt->bind_param("iii", $id, $_SESSION["userid"], $rating);
	$stmt->execute();
	$stmt->close();
	
	$stmt = $conn->prepare("SELECT AVG(rating) as AvgValue FROM vr20_photoratings WHERE photoid = ?");
	$stmt->bind_param("i", $id);
	$stmt->bind_result($score);
	$stmt->execute();
	$stmt->fetch();
	
	$stmt->close();
	$conn->close();
	echo round($score, 2);