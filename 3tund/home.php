<?php
	//require("db/local-configuration.php");
	require("db/tigu-configuration.php");

	// sessiooni käivitamine või kasutamine
	//session_start();
	// var_dump($_SESSION);

	require("classes/Session.class.php");

	SessionManager::sessionStart("vr_20", 0, "/~reino.ristissaar/", "tigu.hk.tlu.ee");

	// kas pole sisse loginud
	if (!isset($_SESSION["userid"])) {
		//jõuge avalehele
		header("Location: page.php");
	}

	// login välja
	if (isset($_GET["logout"])) {
		session_destroy();
		header("Location: page.php");
	}


?>
<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
	<title>Veebirakendused ja nende loomine 2020</title>
</head>
<body>
	<h1>Meie äge koduleht</h1>
	<p>Tere! <?php echo $_SESSION["userFirstName"] . " " . $_SESSION["userLastName"] ?></p>
	<p>See leht on valminud õppetöö raames!</p>
	<p>Logi <a href="?logout=1">välja</a></p>
	<hr>
</body>
</html>