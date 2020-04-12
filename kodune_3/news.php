<?php
require "db/tigu-configuration.php";

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

require "fnc_news.php";

$newsHTML = readNewsPage(5);
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

	<h1>Uudised</h1>
	<p>See leht on valminud õppetöö raames!</p>
	<hr>
	<p>Tere <?php echo $_SESSION["userFirstName"] ?></p>
	<p>Tagasi <a href="home.php">avalehele</a>!</p>
	<a href="?logout=1">Logi välja</a>
	<hr>
  <div>
		<?php echo $newsHTML; ?>
	</div>
	<hr>
</div>

</body>
</html>