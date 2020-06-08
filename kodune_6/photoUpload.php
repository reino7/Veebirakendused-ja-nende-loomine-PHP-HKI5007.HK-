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
require "fnc_main.php";
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
// $thumberror     = null;
// $thumbnotice    = null;
$imageFileType       = null;
$fileUploadSizeLimit = 1048576;
$allowedFileTypes = ["image/jpeg", "image/png"];
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

  $photoUp = new Photo($_FILES["fileToUpload"], $fileUploadSizeLimit, $allowedFileTypes);
		
  if($photoUp->error == null){		
    
    $photoUp->createFileName($fileNamePrefix);
    
    $photoUp->resizePhoto($maxWidth, $maxHeight);
    
    //lisan vesimärgi
    $photoUp->addWatermark("watermark/vr_rr.png", 3, 10);
    
    //loen EXIF
    $photoUp->readExif();
    if($photoUp->photoDate != null){
      $size = 14;
      $y = 20;
      $textToImage = "Pildistatud " .$photoUp->photoDate;
      $photoUp->addText($size, $y, $textToImage);
    } else {
      $notice .= "Pildistamiskuupäev pole teada! ";
    }

			//$result = saveImgToFile($photoUp->myNewImage, $normalPhotoDir .$fileName, $imageFileType);
			//$notice .= $myPic->savePicFile($pic_upload_dir_w600 .$myPic->fileName);
      $result = $photoUp->saveOriginal($originalPhotoDir .$photoUp->fileName);
      if($result == 1) {
				$notice .= "Originaal pilt laeti üles! ";
			} else {
				$error .= "Originaal pildi salvestamisel tekkis viga!";
      }
      
      $result = $photoUp->saveImgToFile($normalPhotoDir .$photoUp->fileName);
      if($result == 1) {
				$notice .= "Vähendatud pilt laeti üles! ";
			} else {
				$error .= "Vähendatud pildi salvestamisel tekkis viga!";
			}
			
			$photoUp->resizePhoto($thumbSize, $thumbSize);
			$result = $photoUp->saveImgToFile($thumbPhotoDir .$photoUp->fileName);
			if($result == 1) {
				$notice .= "Pisipilt laeti üles! ";
			} else {
				$error .= " Pisipildi salvestamisel tekkis viga!";
			}
						
			//kui kõik hästi, salvestame info andmebaasi!!!
			if($error == null){
				$result = addPhotoData2DB($photoUp->fileName, test_input($_POST["altText"]), $_POST["privacy"], $_FILES["fileToUpload"]["name"]);
				if($result == 1){
					$notice .= "Pildi andmed lisati andmebaasi!";
				} else {
					$error .= " Pildi andmete lisamisel andmebaasi tekkis tehniline tõrge: " .$result;
				}
			}
			
			
		} else {
			//1 - pole pildifail, 2 - liiga suur, pole lubatud tüüp
			if($photoUp->error == 1){
				$notice = "Üleslaadimiseks valitud fail pole pilt!";
			}
			if($photoUp->error == 2){
				$notice = "Üleslaadimiseks valitud fail on liiga suure failimahuga!";
			}
			if($photoUp->error == 3){
				$notice = "Üleslaadimiseks valitud fail pole lubatud tüüpi (lubatakse vaid jpg ja png)!";
			}
		}
		
		unset($photoUp);
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