<?php
require "db/configuration.php";
require "fnc_news.php";
require "fnc_users.php";

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

$myName      = "Reino Veebirakendused ja nende loomine";
$fullTimeNow = date("d.m.Y H:i:s");
//<p>Lehe avamise hetkel oli: <strong>31.01.2020 11:32:07</strong></p>
$timeHTML  = "\n <p>Lehe avamise hetkel oli: <strong>" . $fullTimeNow . "</strong></p> \n";
$hourNow   = date("H");
$partOfDay = "hägune aeg";

if ($hourNow < 10) {
  $partOfDay = "hommik";
}
if ($hourNow >= 10 and $hourNow < 18) {
  $partOfDay = "aeg aktiivselt tegutseda";
}
$partOfDayHTML = "<p>Käes on " . $partOfDay . "!</p> \n";

//info semestri kulgemise kohta
$semesterStart    = new DateTime("2020-1-27");
$semesterEnd      = new DateTime("2020-6-22");
$semesterDuration = $semesterStart->diff($semesterEnd);
//echo $semesterDuration;
//var_dump($semesterDuration);
$today             = new DateTime("now");
$fromSemesterStart = $semesterStart->diff($today);
if ($fromSemesterStart->format("%r%a") < 0) {
  $semesterProgressHTML = "<p>Semester pole veel alanud!</p> \n";
} elseif ($fromSemesterStart->format("%r%a") <= $semesterDuration->format("%r%a")) {
  //<p>Semester on hoos: <meter min="0" max="147" value="4"></meter>.</p>
  $semesterProgressHTML = '<p>Semester on hoos: <meter min="0" max="';
  $semesterProgressHTML .= $semesterDuration->format("%r%a");
  $semesterProgressHTML .= '" value="';
  $semesterProgressHTML .= $fromSemesterStart->format("%r%a");
  $semesterProgressHTML .= '"></meter>.</p>' . "\n";
} else {
  $semesterProgressHTML = "<p>Semester on lõppenud!</p> \n";
}

//loen etteantud kataloogist pildifailid
$picsDir           = "pics/";
$photoTypesAllowed = ["image/jpeg", "image/png"];
$photoList         = [];
$allFiles          = array_slice(scandir($picsDir), 2);
//var_dump($allFiles);
foreach ($allFiles as $file) {
  $fileInfo = getimagesize($picsDir . $file);
  if (in_array($fileInfo["mime"], $photoTypesAllowed) == true) {
    array_push($photoList, $file);
  }
}

$photoCount = count($photoList);
//$photoNum = mt_rand(0, $photoCount - 1);
//$randomImageHTML = '<img src="' .$picsDir .$photoList[$photoNum] .'" alt="juhuslik pilt Haapsalust">' ."\n";

$photosToShow    = [];
$photoCountLimit = 3;
if ($photoCount < 3) {
  $photoCountLimit = $photoCount;
}
for ($i = 0; $i < $photoCountLimit; $i++) {
  do {
    $photoNum = mt_rand(0, ($photoCount - 1));
  } while (in_array($photoNum, $photosToShow) == true);
  array_push($photosToShow, $photoNum);
}
$randomImageHTML = "";
for ($i = 0; $i < count($photosToShow); $i++) {
  $randomImageHTML .= '<img src="' . $picsDir . $photoList[$photosToShow[$i]] . '" height="150" alt="juhuslik pilt Haapsalust">' . "\n";
}

//kellaajast sõltuv värvi osa
$bgColor  = "#FFFFFF";
$txtColor = "#000000";
if ($hourNow > 21 or $hourNow < 7) {
  $bgColor  = "#000033";
  $txtColor = "#FFFFEE";
} elseif ($hourNow >= 7 and $hourNow < 12) {
  $bgColor  = "#FFFFEE";
  $txtColor = "#000033";
} elseif ($hourNow >= 12 and $hourNow < 18) {
  $bgColor  = "#FFFFFF";
  $txtColor = "#000066";
} else {
  $bgColor  = "#999999";
  $txtColor = "#000033";
}
$styleHTML = "<style> \n .timeBackground { \n background-color: ";
$styleHTML .= $bgColor;
$styleHTML .= "; \n color: ";
$styleHTML .= $txtColor;
$styleHTML .= "; \n } \n </style> \n";

$newsHTML = readNewsPage(1);

$notice        = null;
$email         = null;
$emailError    = null;
$passwordError = null;

if (isset($_POST["login"])) {
  if (isset($_POST["email"]) and !empty($_POST["email"])) {
    $email = test_input($_POST["email"]);
  } else {
    $emailError = "Palun sisesta kasutajatunnusena e-posti aadress!";
  }

  if (!isset($_POST["password"]) or strlen($_POST["password"]) < 8) {
    $passwordError = 'Palun sisesta parool, vähemalt 8 märki!';
  }

  if (empty($emailError) and empty($passwordError)) {
    $notice = signIn($email, $_POST["password"]);
  } else {
    $notice = "Ei saa sisse logida!";
  }
}
?>

<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
  <title>Veebirakendused ja nende loomine 2020</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<?php
    echo $styleHTML;
  ?>
</head>
<body>
  <?php 
		require "includes/header.inc.php";
	?>

  <div class="container">

    <div class="jumbotron">
      <h1 class="timeBackground"><?php echo $myName; ?></h1>
      <p class="lead">See leht on valminud õppetöö raames!</p>
    </div>

    <!-- <form class="form-signin" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <h1 class="h3 mb-3 font-weight-normal">Palun logi sisse</h1>
      <label for="inputEmail" class="sr-only">E-post (kasutajatunnus)</label>
      <input type="email" name="email" value="<?php echo $email; ?>" class="form-control w-25" placeholder="E-posti aadress" autofocus><span><?php echo $emailError; ?></span>
      <label for="inputPassword" class="sr-only">Salasõna</label>
      <input type="password" name="password" class="form-control w-25" placeholder="Salasõna" required><span class="w-100"><?php echo $passwordError; ?>
      <input name="login" type="submit" value="Logi sisse!" class="btn btn-primary mt-3"><span><?php echo $notice; ?></span>
    </form>
    <p class="mt-3">Loo endale <a href="newuser.php">kasutajakonto</a>!</p> -->


    <hr>
      <?php
        echo $timeHTML;
        echo $partOfDayHTML;
        echo $semesterProgressHTML;
        echo $randomImageHTML;
      ?>
    <br>
    <br>
    <hr>
    <h2>Uudis</h2>
    <div>
      <?php echo $newsHTML; ?>
    </div>
  </div>
	<?php 
		require "includes/footer.inc.php";
	?>