<?php

  require 'helper.php';
  require '../db/configuration.php';
  require 'fnc_news.php';

  //var_dump($_POST);
  //make_array_readable($_POST);
  
  $newsTitle = null;
  $newsContent = null;
  $newsError = null;

  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  // kui vajutati newsBtn, siis rageerib
  // kasulik eriti, kui vorme on lehel rohkem
  if(isset($_POST["newsBtn"])) {
    if(isset($_POST["newsTitle"]) and !empty(test_input($_POST["newsTitle"]))) {
      $newsTitle = test_input($_POST["newsTitle"]);
    } else {
      $newsError = '<div class="alert alert-danger" role="alert">Uudise pealkiri on sisestamata! </div>';
    }
    if(isset($_POST["newsEditor"]) and !empty(test_input($_POST["newsEditor"]))) {
      $newsContent = test_input($_POST["newsEditor"]);
    } else {
      $newsError .= '<div class="alert alert-danger" role="alert">Uudise sisu on kirjutamata! </div>';
    }
    // echo $newsTitle . "\n";
    // echo $newsContent;

    // Saadame andmebaasi
    if(empty($newsError)) {
      // echo "Salvestame!";
      $response = saveNews($newsTitle, $newsContent);

      if($response == 1) {
        $newsError = "Uudis on salvestatud";
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

    <h1>Uudise lisamine</h1>
    <!-- action järgi eemdaladab HTML koodi sisestamise võimaluse -->
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
      <label>Uudise pealkiri:</label><br>
      <input type="text" name="newsTitle" placeholder="Uudise pealkiri" value="<?php echo $newsTitle; ?>"><br><br>
      <label>Uudise sisu:</label><br>
      <textarea name="newsEditor" placeholder="Uudise sisu" rows="6" cols="40"><?php echo $newsContent; ?></textarea>
      <br><br>
      <input type="submit" name="newsBtn" value="Salvesta uudis nupp" class="btn btn-primary"><br><br>
      <span> <?php echo $newsError; ?> </span>
    </form>
  
  </div>

</body>
</html>