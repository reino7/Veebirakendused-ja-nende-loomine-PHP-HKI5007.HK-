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

require "db/tigu-configuration.php";

// pildi üleslaadimise osa
// var_dump($_POST);     // siin on kogu muu kraam
// var_dump($_FILES);  // siin on üleslaetavad failid

$originalPhotoDir    = "uploadOriginalPhoto/";
$normalPhotoDir      = "uploadNormalPhoto/";
$error               = null;
$notice              = null;
$imageFileType       = null;
$fileUploadSizeLimit = 1048576;
$fileNamePrefix      = "vr20_";
$maxWitdh            = 600;
$maxHeight           = 400;

if (isset($_POST["photoSubmit"])) {

  // kas üldse on pilt?
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);

  if ($check !== false) {

    // faili tüübi väljaselgitamine ja sobivuse kontroll
    if ($check["mime"] == "image/jpeg") {
      $imageFileType = "jpg";
    } elseif ($check["mime"] == "image/png") {
      $imageFileType = "png";
    } else {
      $error = "Ainult jpg ja png pildid on lubatud! ";
    }

  } else {
    $error = "Valitud fail ei ole pilt! ";
  }

  // ega pole liiga suur
  if ($_FILES["fileToUpload"]["size"] > $fileUploadSizeLimit) {
    $error .= "Valitud fail on liiga suur! ";
  }

  // loome oma nime failile
  $timestamp = microtime(1) * 10000;
  $fileName  = $fileNamePrefix . $timestamp . "." . $imageFileType;

  // $originalTarget = $originalPhotoDir. $_FILES["fileToUpload"]["name"];
  $originalTarget = $originalPhotoDir . $fileName;

  // äkki on fail olemas?
  if (file_exists($originalTarget)) {
    $error = "Selline fail on juba olemas!";
  }

  // kui vigu pole
  if ($error == null) {

    // teen pildi väiksemaks
    if ($imageFileType == "jpg") {
      $myTempImage = imagecreatefromjpeg($_FILES["fileToUpload"]["tmp_name"]);
    }

    if ($imageFileType == "png") {
      $myTempImage = imagecreatefrompng($_FILES["fileToUpload"]["tmp_name"]);
    }

    $imageW = imagesx($myTempImage);
    $imageH = imagesy($myTempImage);

    if ($imageW / $maxWitdh > $imageH / $maxHeight) {
      $imageSizeRatio = $imageW / $maxWitdh;
    } else {
      $imageSizeRatio = $imageH / $maxHeight;
    }

    $newW = round($imageW / $imageSizeRatio);
    $newH = round($imageH / $imageSizeRatio);

    // loome uue ajutise pildiobjekti
    $myNewImage = imagecreatetruecolor($newH, $newW);
    imagecopyresampled($myNewImage, $myTempImage, 0, 0, 0, 0, $newW, $newH, $imageW, $imageH);

    // salvestame vähendatud kujutise faili
    if ($imageFileType == "jpg") {
      if (imagejpeg($myNewImage, $normalPhotoDir . $fileName, 90)) {
        $notice = "Vähendatud pilt laeti üles!";
      } else {
        $error = "Vähendatud pildi salvestamisel tekkis viga!";
      }
    }

    if ($imageFileType == "png") {
      if (imagepng($myNewImage, $normalPhotoDir . $fileName, 6)) {
        $notice = "Vähendatud pilt laeti üles!";
      } else {
        $error = "Vähendatud pildi salvestamisel tekkis viga!";
      }
    }

    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $originalTarget)) {
      $error .= "Originaalpilt laeti üles!";
    } else {
      $notice .= "Pildi üleslaadimisel tekkis viga!";
    }

    imagedestroy($myTempImage);
    imagedestroy($myNewImage);

    // andmebaasi

  }

  // kui vigu pole

}

?>

<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
	<title>Veebirakendused ja nende loomine 2020</title>
</head>
<body>
	<h1>Fotode üleslaadimine</h1>
	<p>See leht on valminud õppetöö raames!</p>
	<p><?php echo $_SESSION["userFirstName"] . " " . $_SESSION["userLastName"] . "."; ?> Logi <a href="?logout=1">välja</a>!</p>
	<p>Tagasi <a href="home.php">avalehele</a>!</p>
	<hr>

	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
	<label>Vali pildifail: </label><br>
	<input type="file" name="fileToUpload"><br>
	<label>Alt tekst:</label>
	<input type="text" name="altText"><br>
	<label>Privaatsus</label><br>
	<label for="priv1">Privaatne</label><input id="priv1" type="radio" name="privacy" value="3" checked>
	<label for="priv2">Sisseloginud kasutajatele</label><input id="priv2" type="radio" name="privacy" value="2">
	<label for="priv3">Avalik</label><input id="priv3" type="radio" name="privacy" value="1">
	<br>
	<input type="submit" name="photoSubmit" value="Lae valitud pilt üles!">
	<span><?php echo $error;
echo $notice; ?></span>
	</form>

	<br>
	<hr>
</body>
</html>