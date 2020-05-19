<?php
		require("db/configuration.php");
	
	//sessiooni käivitamine või kasutamine
	//session_start();
	//var_dump($_SESSION);
	require("classes/Session.class.php");
	SessionManager::sessionStart("vr20", 0, "/~reino.ristissaar/", "tigu.hk.tlu.ee");
	
	//kas pole sisseloginud
	if(!isset($_SESSION["userid"])){
		//jõuga avalehele
		header("Location: page.php");
	}
	
	//login välja
	if(isset($_GET["logout"])){
		session_destroy();
		header("Location: page.php");
	}

	require("db/configuration.php");
	require("fnc_gallery.php");
	
	$privateThumbnails = readAllSemiPublicPictureThumbs();
?>
<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
	<title>Veebirakendused ja nende loomine 2020</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
	    
	<?php 
		require "includes/header.inc.php";
	?>
  <div class="container">

		<h2>Kasutajate avaldatavad pildid</h2>
		<hr>
		<?php echo $privateThumbnails;; ?>

		</div>

<?php 
	require "includes/footer.inc.php";
?>