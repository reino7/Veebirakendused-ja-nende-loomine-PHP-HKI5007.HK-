<?php

require 'helper.php';
require 'db/tigu-configuration.php';
require 'fnc.php';

// debugging: view $_POST array content
//make_array_readable($_POST);

// set variables to null
$course    = null;
$activity  = null;
$studytime = null;
$saveError = null;
$getCoursesHTML = getCourses();
$getActivitiesHTML = getActivities();


function testInputData($data)
{

  // strips unnecessary characters (extra space, tab, newline)
  $data = trim($data);
  // removes backslashes (\)
  $data = stripslashes($data);
  // converts special characters to HTML entities
  $data = htmlspecialchars($data);

  return $data;

}

if (isset($_POST["saveBtn"])) {

    if (!empty(testInputData($_POST["studytime"]))) {
        $studytime = $_POST["studytime"];
    } else {
        $saveError = '<div class="alert alert-danger text-center" role="alert">Õppimise aeg sisestamata!</div>';
    }

    if (!empty(testInputData($_POST["activity"]))) {
        $activity = $_POST["activity"];
    } else {
        $saveError = '<div class="alert alert-danger text-center" role="alert">Tegevus valimata!</div>';
    }

    if (!empty(testInputData($_POST["course"]))) {
        $course = $_POST["course"];
    } else {
        $saveError = '<div class="alert alert-danger text-center" role="alert">Õppeaine valimata!</div>';
    }

    // debugging: view saved values for variabled
    // echo $course;
    // echo $activity;
    // echo $studytime;

    // save values to db
    if (empty($saveError)) {
        // echo "Salvestame!";
        $response = saveLog($course, $activity, $studytime);

        if ($response == 1) {
            $saveError = '<div class="alert alert-success text-center" role="alert">Salvestatud!</div>';
        } else {
            $saveError = '<div class="alert alert-danger text-center" role="alert">Salvestamisel tekkis viga!</div>';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="et">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Õppimise logi</title>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

</head>

<body>

  <!-- Site navigation -->
  <?php
    require 'nav.php';
  ?>

  <!-- Main content -->
  <div class="container py-5">

  <h3>Õppimise logi</h3>
  <p>Vali rippmenüüst õppeaine, tegevus ja palju aega läks</p>

      <!-- Error output -->
      <div>
        <span> <?php echo $saveError; ?> </span>
      </div>

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="form-group pb-3">

      <!-- Õppeaine rippmenüü -->
      <label for="course">Õppeaine</label>
      <select name="course" id="course" class="form-control">
        <option value="" selected>Vali...</option>
        <?php echo $getCoursesHTML; ?>
        <!-- <option value="1">Multimeediumi praktika (HKI5068.HK)</option>
        <option value="2">Veebirakendused ja nende loomine (HKI5096.HK)</option>
        <option value="3">Andmeturve (HKI6010.HK)</option>
        <option value="4">Mobiilirakenduste arendamine (HKI5061.HK)</option>
        <option value="5">Digitaalne helikujundus (HKI5066.HK)</option> -->
      </select>

      <!-- Tegevused rippmenüü -->
      <label for="activity" class="mt-3">Tegevused</label>
      <select name="activity" id="activity" class="form-control">
        <option value="" selected>Vali...</option>
        <?php echo $getActivitiesHTML; ?>
        <!-- <option value="1">Iseseisev materjali omandamine</option>
        <option value="2">Koduste ülesannete lahendamine</option>
        <option value="3">Kordamine</option>
        <option value="4">Rühmatöö</option> -->
      </select>

      <!-- numbri sisestus, mis laseb valida veerand tunni täpsusega -->
      <label for="activity" class="mt-3">Palju aega läks?</label>
      <input type="number" min=".25" max="24" step=".25" name="studytime" id="studytime" placeholder="näide: 1.15" class="form-control w-25">

      <!-- Salvesta väärtused -->
      <input type="submit" name="saveBtn" value="Salvesta" class="btn btn-primary mt-3">

    </form>

  </div>
</body>

</html>