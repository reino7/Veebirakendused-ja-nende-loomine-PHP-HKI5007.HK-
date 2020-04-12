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
require "db/fnc_photoupload.php";

// pildi üleslaadimise osa
// var_dump($_POST); // siin on kogu muu kraam
// var_dump($_FILES); // siin on üleslaetavad failid

$originalPhotoDir    = "uploadOriginalPhoto/";
$normalPhotoDir      = "uploadNormalPhoto/";
$thumbPhotoDir       = "uploadThumbPhoto/";
$error               = null;
$notice              = null;
$imageFileType       = null;
$fileUploadSizeLimit = 1048576;
$fileNamePrefix      = "vr20_";
// normal picture size
$maxNormalWitdh  = 600;
$maxNormalHeight = 400;
// thumbnail picture size
$maxThumbWitdh  = 100;
$maxThumbHeight = 100;
$warningStart   = '<div class="alert alert-warning w-25" role="alert">';
$warningEnd     = '</div>';

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
      $error = $warningStart . "Ainult jpg ja png pildid on lubatud! " . $warningEnd;
    }

  } else {
    $error = $warningStart . "Valitud fail ei ole pilt! " . $warningEnd;
  }

  // ega pole liiga suur
  if ($_FILES["fileToUpload"]["size"] > $fileUploadSizeLimit) {
    $error .= $warningStart . "Valitud fail on liiga suur! " . $warningEnd;
  }

  // loome oma nime failile
  $timestamp = microtime(1) * 10000;
  $fileName  = $fileNamePrefix . $timestamp . "." . $imageFileType;

  // $originalTarget = $originalPhotoDir. $_FILES["fileToUpload"]["name"];
  $originalTarget = $originalPhotoDir . $fileName;

  // äkki on fail olemas?
  if (file_exists($originalTarget)) {
    $error = $warningStart . "Selline fail on juba olemas!" . $warningEnd;
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

    // Thumbnail size image
    if ($imageW / $maxThumbWitdh > $imageH / $maxThumbHeight) {
      $imageSizeThumbRatio = $imageW / $maxThumbWitdh;
    } else {
      $imageSizeThumbRatio = $imageH / $maxThumbHeight;
    }

    // Normal size image
    if ($imageW / $maxNormalWitdh > $imageH / $maxNormalHeight) {
      $imageSizeNormalRatio = $imageW / $maxNormalWitdh;
    } else {
      $imageSizeNormalRatio = $imageH / $maxNormalHeight;
    }

    $newThumbW  = round($imageW / $imageSizeThumbRatio);
    $newThumbH  = round($imageH / $imageSizeThumbRatio);
    $newNormalW = round($imageW / $imageSizeNormalRatio);
    $newNormalH = round($imageH / $imageSizeNormalRatio);

    // loome uue ajutise pildiobjekti
    $myNewThumbImage  = imagecreatetruecolor($newThumbW, $newThumbH);
    $myNewNormalImage = imagecreatetruecolor($newNormalW, $newNormalH);
    imagecopyresampled($myNewThumbImage, $myTempImage, 0, 0, 0, 0, $newThumbW, $newThumbH, $imageW, $imageH);
    imagecopyresampled($myNewNormalImage, $myTempImage, 0, 0, 0, 0, $newNormalW, $newNormalH, $imageW, $imageH);

    // salvestame vähendatud kujutise faili

    // salvestame Thumb suurusega kujutise faili
    if ($imageFileType == "jpg") {
      if (imagejpeg($myNewThumbImage, $thumbPhotoDir . $fileName, 90)) {
        $notice = $warningStart . "Thumbnail pilt laeti üles!" . $warningEnd;
      } else {
        $error = $warningStart . "Thumbnail pildi salvestamisel tekkis viga!" . $warningEnd;
      }
    }

    if ($imageFileType == "png") {
      if (imagepng($myNewThumbImage, $thumbPhotoDir . $fileName, 6)) {
        $notice = $warningStart . "Thumbnail pilt laeti üles!" . $warningEnd;
      } else {
        $error = $warningStart . "Thumbnail pildi salvestamisel tekkis viga!" . $warningEnd;
      }
    }

    // salvestame Normal suurusega kujutise faili
    if ($imageFileType == "jpg") {
      if (imagejpeg($myNewNormalImage, $normalPhotoDir . $fileName, 90)) {
        $notice = $warningStart . "Vähendatud pilt laeti üles!" . $warningEnd;
      } else {
        $error = $warningStart . "Vähendatud pildi salvestamisel tekkis viga!" . $warningEnd;
      }
    }

    if ($imageFileType == "png") {
      if (imagepng($myNewNormalImage, $normalPhotoDir . $fileName, 6)) {
        $notice = $warningStart . "Vähendatud pilt laeti üles!" . $warningEnd;
      } else {
        $error = $warningStart . "Vähendatud pildi salvestamisel tekkis viga!" . $warningEnd;
      }
    }

    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $originalTarget)) {
      $error .= $warningStart . "Originaalpilt laeti üles!" . $warningEnd;
    } else {
      $notice .= $warningStart . "Pildi üleslaadimisel tekkis viga!" . $warningEnd;
    }

    imagedestroy($myTempImage);
    imagedestroy($myNewThumbImage);
    imagedestroy($myNewNormalImage);

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
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
  <div class="container">
    <h1>Fotode üleslaadimine</h1>
    <p>See leht on valminud õppetöö raames!</p>
    <p><?php echo $_SESSION["userFirstName"] . " " . $_SESSION["userLastName"] . "."; ?> Logi <a href="?logout=1">välja</a>!</p>
    <p>Tagasi <a href="home.php">avalehele</a>!</p>
    <hr>

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">

    <br>

      <span>
        <?php
echo $error;
echo $notice;
?>
      </span>

      <div class="form-group">
        <label for="fileToUpload">Vali pildifail: </label>
        <br>
        <input type="file" name="fileToUpload" class="form-control-file" id="fileToUpload">
        <small id="passwordHelpBlock" class="form-text text-muted">
          Laadida saad kuni 1MB suuruse JPG, JPEG või PNG pildifaili.
        </small>
        <br>
        <label>Alt tekst:</label>
        <input type="text" name="altText">
      </div>

      <label>Privaatsus</label>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="privacy" id="priv1" value="1" checked>
        <label class="form-check-label" for="priv1">
          Privaatne
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="privacy" id="priv2" value="2">
        <label class="form-check-label" for="priv2">
          Sisseloginud kasutajatele
        </label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="privacy" id="priv3" value="3">
        <label class="form-check-label" for="priv3">
          Avalik
        </label>
      </div>

      <input type="submit" class="btn btn-primary mt-3" name="photoSubmit" value="Lae valitud pilt üles!">

    </form>
    <br>
  <hr>
  </div>
</body>
</html>