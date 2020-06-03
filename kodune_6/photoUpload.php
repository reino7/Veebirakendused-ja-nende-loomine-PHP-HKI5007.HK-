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
require "fnc_photoUpload.php";
require "classes/Photo.class.php";

// // pildi üleslaadimise osa
// echo "<pre>";
// var_dump($_POST); // siin on kogu muu kraam
// echo "</pre>";

// echo "<pre>";
// var_dump($_FILES); // siin on üleslaetavad failid
// echo "</pre>";

// $originalPhotoDir    = "uploadOriginalPhoto/";
// $normalPhotoDir      = "uploadNormalPhoto/";
// $thumbPhotoDir       = "uploadThumbPhoto/";

$error  = null;
$notice = null;
$showEXIFInfo = null;
// $thumberror     = null;
// $thumbnotice    = null;
$imageFileType       = null;
$fileUploadSizeLimit = 1048576;
$fileNamePrefix      = "vr20_";
$fileName            = null;
// normal picture size
$maxWidth  = 600;
$maxHeight = 400;
// thumbnail picture size
$thumbSize = 100;
$warningStart        = '<div class="alert alert-warning w-50" role="alert">';
$warningEnd          = '</div>';

if (isset($_POST["photoSubmit"]) and !empty($_FILES["fileToUpload"]["tmp_name"])) {

  // // kontrollime, kas tegemist on üldse pildiga
  // $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);

  // if ($check !== false) {

  //   // faili tüübi väljaselgitamine ja sobivuse kontroll
  //   if ($check["mime"] == "image/jpeg") {
  //     $imageFileType = "jpg";
  //   } elseif ($check["mime"] == "image/png") {
  //     $imageFileType = "png";
  //   } else {
  //     $error = "Ainult jpg/jpeg ja png pildid on lubatud! ";
  //   }

  // } else {
  //   $error = "Valitud fail ei ole pilt! ";
  // }

  //ega pole liiga suur
  if ($_FILES["fileToUpload"]["size"] > $fileUploadSizeLimit) {
    $error .= "Valitud fail on liiga suur! ";
  }

  // loome oma nime failile
  $timestamp = microtime(1) * 10000;
  $fileName  = $fileNamePrefix . $timestamp . "." . $imageFileType;

  //$originalTarget = $originalPhotoDir .$_FILES["fileToUpload"]["name"];
  $originalTarget = $originalPhotoDir . $fileName;

  //äkki on fail olemas?
  if (file_exists($originalTarget)) {
    $error .= "Selline fail on juba olemas!";
  }

  //kui vigu pole
  if ($error == null) {

    $photoUp = new Photo($_FILES["fileToUpload"]);

    //teen pildi väiksemaks
    // if ($imageFileType == "jpg") {
    //   $myTempImage = imagecreatefromjpeg($_FILES["fileToUpload"]["tmp_name"]);
    // }
    // if ($imageFileType == "png") {
    //   $myTempImage = imagecreatefrompng($_FILES["fileToUpload"]["tmp_name"]);
    // }
   
    //$myNewImage = resizePhoto($myTempImage, $maxWidth, $maxHeight);
    $photoUp->resizePhoto($maxWidth, $maxHeight);
    
    // lisan väsimärgi
    // väsimärgi faili asukoht, 2 pareml üleval ääres, kaugus servast 10 pixlit
    $photoUp->addWatermark($wmFile, $wmLocation, $fromEdge);
    // $result = saveImgToFile($photoUp->myNewImage, $normalPhotoDir . $fileName, $imageFileType);
    $result = $photoUp->saveImgToFile($normalPhotoDir . $fileName);

    if ($result == 1) {
      $notice = $warningStart . "Vähendatud pilt laeti üles!" . $warningEnd;
    } else {
      $error = $warningStart . "Vähendatud pildi salvestamsiel tekkis viga!" . $warningEnd;
    }

    // EXIF info lugemine uploadi käigus
    // $showEXIFInfo = $photoUp->getEXIFInfo();
    // echo $showEXIFInfo;

    // if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $originalTarget)) {
    //   $notice .= "Originaalpilt laeti üles!";
    // } else {
    //   $error .= " Pildi üleslaadimisel tekkis viga!";
    // }

    $photoUp->resizePhoto($thumbSize, $thumbSize);

    // lõpetame vähendatud pildiga ja teeme thumbnaili
    // imagedestroy($myNewImage);
    // $myNewImage = resizePhoto($myTempImage, $thumbSize, $thumbSize);
    // $result = saveImgToFile($photoUp->myNewImage, $thumbPhotoDir . $fileName, $imageFileType);
    $result = $photoUp->saveImgToFile($thumbPhotoDir . $fileName);

    if ($result == 1) {
      $notice .= $warningStart . "Pisipilt laeti üles!" . $warningEnd;
    } else {
      $error .= $warningStart . "Pisipildi salvestamsiel tekkis viga!" . $warningEnd;
    }
    
    // imagedestroy($myTempImage);
    // imagedestroy($myNewImage);
    unset($photoUp);
    
    if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $originalTarget)){
      $notice .= $warningStart . "Originaalpilt laeti üles! " . $warningEnd;
    } else {
      $error .= $warningStart . "Pildi üleslaadimisel tekkis viga!" . $warningEnd;
    }
    
    //kui kõik hästi, salvestame info andmebaasi!!!
    if($error == null){
      $result = addPhotoData2DB($fileName, $_POST["altText"], $_POST["privacy"], $_FILES["fileToUpload"]["name"]);
      if($result == 1){
        $notice .= $warningStart . "Pildi andmed lisati andmebaasi!" . $warningEnd;
      } else {
        $error .= $warningStart . "Pildi andmete lisamisel andmebaasi tekkis tehniline tõrge: " .$result . $warningEnd;
      }
    }
  } //kui vigu pole

}


?>

<!DOCTYPE html>
<html lang="et">

<head>
  <meta charset="utf-8">
  <title>Veebirakendused ja nende loomine 2020</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body>

  <?php 
		require "includes/header.inc.php";
	?>

  <div class="container">
    <h2>Fotode üleslaadimine</h2>
    <hr>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
      <br>
      <span>
        <?php
          echo $error;
          echo $notice;
        ?>
      </span>
      <br>

      <div class="form-group">
        <label for="fileToUpload">Vali pildifail: </label>
        <br>
        <input type="file" name="fileToUpload" class="form-control-file w-25" id="fileToUpload">
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
  </div>

  <?php 
		require "includes/footer.inc.php";
	?>