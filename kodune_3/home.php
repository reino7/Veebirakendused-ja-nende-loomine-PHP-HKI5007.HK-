<?php
require "db/tigu-configuration.php";

//sessiooni käivitamine või kasutamine
//session_start();
//var_dump($_SESSION);
require "classes/Session.class.php";
SessionManager::sessionStart("vr20", 0, "/~reino.ristissaar/", "tigu.hk.tlu.ee");

//kas pole sisseloginud
if (!isset($_SESSION["userid"])) {
    //jõuga avalehele
    header("Location: page.php");
}

//login välja
if (isset($_GET["logout"])) {
    session_destroy();
    header("Location: page.php");
}

/* require("fnc_news.php");

$newsHTML = readNewsPage(5); */
?>
<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
	<title>Veebirakendused ja nende loomine 2020</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
<div class="container py-5">

	<h1>Meie äge koduleht</h1>
	<p>See leht on valminud õppetöö raames!</p>

	<p>Tere <?php echo $_SESSION["userFirstName"] . " " . $_SESSION["userLastName"]; ?></p>
	<p>Logi <a href="?logout=1">välja</a>!</p>
	<hr>

	<h2>Mida siin teha?</h2>
	<ul>
		<li><a href="addnews.php">Uudiste lisamine</a></li>
		<li><a href="news.php">Uudiste lugemine</a></li>
	</ul>

</div>

</body>
</html>