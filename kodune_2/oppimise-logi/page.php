<?php

  require 'helper.php';
  require 'db/configuration.php';


?>

<!DOCTYPE html>
<html lang="et">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Õppimise logi</title>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

</head>

<body>

  <!-- Side navigation -->
  <?php
    require 'nav.php';
  ?>

  <!-- Main content -->
  <div class="container py-5">
  
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

      <!-- Õppeaine rippmenüü -->
      <select name="course" id="course">
        <option value="" selected disabled>Õppeaine</option>
        <option value="HKI5068.HK">Multimeediumi praktika (HKI5068.HK)</option>
        <option value="HKI5096.HK">Veebirakendused ja nende loomine (HKI5096.HK)</option>
        <option value="HKI6010.HK">Andmeturve (HKI6010.HK)</option>
        <option value="HKI5061.HK">Mobiilirakenduste arendamine (HKI5061.HK)</option>
        <option value="HKI5066.HK">Digitaalne helikujundus (HKI5066.HK)</option>
      </select>

      <!-- Tegevused rippmenüü -->
      <select name="activity" id="activity">
        <option value="" selected disabled>Tegevused</option>
        <option value="selfstudy">Iseseisev materjali omandamine</option>
        <option value="homework">Koduste ülesannete lahendamine</option>
        <option value="repetition">Kordamine</option>
        <option value="teamwork">Rühmatöö</option>
      </select>

      <!-- numbri sisestus, mis laseb valida veerand tunni täpsusega -->
      <input type="number" min=".25" max="24" step=".25" name="elapsedTime" placeholder="1.15">

      <!-- Salvesta väärtused -->
      <input type="submit" name="saveBtn" value="Salvesta" class="btn btn-primary">

    </form>

  </div>
</body>

</html>