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
	require("classes/Photo.class.php");
	require("fnc_gallery.php");

	$privateThumbnails = readAllPrivatePictureThumbs();
	$photosInDB = countPics(3);

?>
<!DOCTYPE html>
<html lang="et">

<head>
  <meta charset="utf-8">
  <title>Veebirakendused ja nende loomine 2020</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link href="css/lightbox.min.css" rel="stylesheet" />
</head>

<body>

  <?php 
		require "includes/header.inc.php";
	?>
  <div class="container">

		<h2>Minu fotod (<?php echo $photosInDB; ?>)</h2>
    <hr>

    <div class="row text-center">

      <?php echo $privateThumbnails; ?>

			<ul class="pagination justify-content-center">
          <li class="page-item">
            <a class="page-link" href="galleryPrivate.php?limit=8&offset=<?php echo ($_GET["offset"] - $_GET["limit"]) ?>">Previous</a>
          </li>
          <li class="page-item">
            <a class="page-link" href="galleryPrivate.php?limit=8&offset=<?php echo ($_GET["offset"] + $_GET["limit"]) ?>">Next</a>
          </li>
				</ul>
				
    </div>

  </div>

  <?php 
		require "includes/footer.inc.php";
	?>