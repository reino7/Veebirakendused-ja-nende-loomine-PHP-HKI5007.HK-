<?php

require 'helper.php';
require '../db/configuration.php';
require 'fnc_news.php';

$newsHTML = readNews();
?>

<!DOCTYPE html>
<html lang="et">

<head>
	<meta charset="utf-8">
  <title>Veebirakendused ja nende loomine 2020</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="main.css">
</head>

<body>
  
  <!-- Side navigation -->
  <div class="sidenav">
    <a href="addnews.php">Lisa uudis</a>
    <a href="news.php">Kõik uudiseid</a>
    <a href="latestnews.php">Viimased uudiseid</a>
  </div>

  <!-- Main content -->
  <div class="main">

    <p class="alert alert-warning text-center mb-5" role="alert">See leht on valminud õppetöö raames!</p>

    <h1>Uudised</h1>
    <hr>
    <div>
      <?php echo $newsHTML; ?>
    </div>
  </div>

</body>
</html>