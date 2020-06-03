<?php

require 'helper.php';
require 'db/configuration.php';

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

require "db/configuration.php";

require 'fnc_studylog.php';

$log = readLog();
?>


<!DOCTYPE html>
<html lang="et">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Vaata logi</title>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

</head>

<body>
	  
  <?php 
		require "includes/header.inc.php";
	?>

  <!-- Main content -->

  <div class="container py-5">

    <table class="table table-hover">
      <thead>
        <tr>
          <th scope="col">Sisestatud</th>
          <th scope="col">Õppeaine</th>
          <th scope="col">Tegevus</th>
          <th scope="col" class="text-center">Aega kulus (h:m)</th>
        </tr>
      </thead>
      <tbody>
        <?php echo $log; ?>
      </tbody>
    </table>

  </div>


	<?php 
		require "includes/footer.inc.php";
	?>
