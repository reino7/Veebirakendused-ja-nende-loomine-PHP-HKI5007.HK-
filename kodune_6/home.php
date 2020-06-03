<?php
require "db/configuration.php";
require "fnc_news.php";

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
$newsHTML = readNewsPage(3);

?>
<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
	<title>Veebirakendused ja nende loomine 2020</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>

	<?php 
		require "includes/header.inc.php";
	?>

	<div class="container">
		<h1 class="mb-4">Tere! <?php echo $_SESSION["userFirstName"] . " " . $_SESSION["userLastName"]; ?></h1>
		<hr>

		<h2 class="mb-3"><u>Viimased uudised:</u></h2>
		<?php echo $newsHTML; ?>

	<?php 
		require "includes/footer.inc.php";
	?>

