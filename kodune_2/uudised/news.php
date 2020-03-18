<?php

require 'helper.php';
require 'db/configuration.php';
require 'fnc_news.php';

$newsHTML = readNews(1000);
?>

<!DOCTYPE html>
<html lang="et">

<head>
	<meta charset="utf-8">
  <title>Veebirakendused ja nende loomine 2020</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="css/main.css">
</head>

<body>
  
  <!-- Side navigation -->
  <?php
    require 'nav.php';
  ?>

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