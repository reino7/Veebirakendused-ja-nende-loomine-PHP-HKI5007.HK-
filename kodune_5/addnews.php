<?php
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
require "fnc_news.php";
//include
//var_dump($_POST);
//echo $_POST["newsTitle"];
$newsTitle   = null;
$newsContent = null;
$newsError   = null;

function test_input($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

if (isset($_POST["newsBtn"])) {
  if (isset($_POST["newsTitle"]) and !empty(test_input($_POST["newsTitle"]))) {
    $newsTitle = test_input($_POST["newsTitle"]);
  } else {
    $newsError = "Uudise pealkiri on sisestamata! ";
  }
  if (isset($_POST["newsEditor"]) and !empty(test_input($_POST["newsEditor"]))) {
    $newsContent = test_input($_POST["newsEditor"]);
  } else {
    $newsError .= "Uudise sisu on kirjutamata!";
  }
  //echo $newsTitle ."\n";
  //echo $newsContent;
  //saadame andmebaasi
  if (empty($newsError)) {
    //echo "Salvestame!";
    $response = saveNews($newsTitle, $newsContent);
    if ($response == 1) {
      $newsError   = "Uudis on salvestatud!";
      $newsTitle   = null;
      $newsContent = null;
    } else {
      $newsError = "Uudise salvestamisel tekkis tõrge!";
    }
  }
}
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
    <h1>Uudise lisamine</h1>
    <hr>
    <br>
      <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <label>Uudise pealkiri: </label><br>
      <input type="text" class="form-control" name="newsTitle" placeholder="Uudise pealkiri" value="<?php echo $newsTitle; ?>"><br>
      <label>Uudise sisu</label><br>
      <textarea name="newsEditor" class="form-control" placeholder="Uudis" rows="6" cols="40"><?php echo $newsContent; ?></textarea>
      <br>
      <input type="submit" name="newsBtn" value="Salvesta uudis" class="btn btn-primary mt-3">
      <span><?php echo $newsError; ?></span>
    </form>
  </div>
  
  <?php 
		require "includes/footer.inc.php";
	?>
