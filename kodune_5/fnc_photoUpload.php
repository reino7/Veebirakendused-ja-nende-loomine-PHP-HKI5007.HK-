<?php

function addPhotoData2DB($fileName, $alt, $privacy, $origName)
{
  $notice = null;
  $conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUserName"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
  $stmt = $conn->prepare("INSERT INTO vr20_photos (userid, filename, alttext, privacy, origname) VALUES (?, ?, ?, ?, ?)");
  echo $conn->error;
  $stmt->bind_param("issis", $_SESSION["userid"], $fileName, $alt, $privacy, $origName);

  if ($stmt->execute()) {
    $notice = 1;
  } else {
    $notice = $stmt->error;
  }

  $stmt->close();
  $conn->close();
  
  return $notice;

}


function resizePhotos($myTempImage, $fileName, $imageFileType)
{

  $originalPhotoDir    = "uploadOriginalPhoto/";
  $normalPhotoDir      = "uploadNormalPhoto/";
  $thumbPhotoDir       = "uploadThumbPhoto/";
  $error               = null;
  $notice              = null;
  $thumberror          = null;
  $thumbnotice         = null;
  $warningStart        = '<div class="alert alert-warning w-25" role="alert">';
  $warningEnd          = '</div>';
  $fileUploadSizeLimit = 1048576; // = 1 MB / 2097152 = 2MB / 3145728 = 3MB

  // thumbnail picture size
  $maxThumbWitdh  = 100;
  $maxThumbHeight = 100;
  // normal picture size
  $maxNormalWitdh  = 600;
  $maxNormalHeight = 400;

  // Määrame maksimaalse pildi üleslaadimis suurus
  if ($_FILES["fileToUpload"]["size"] > $fileUploadSizeLimit) {
    $error .= $warningStart . "Valitud fail on liiga suur! " . $warningEnd;
  }

  $originalTarget = $originalPhotoDir . $fileName;

  if ($error == null) {

    if ($imageFileType == "jpg") {
      $myTempImage = imagecreatefromjpeg($_FILES["fileToUpload"]["tmp_name"]);
    }

    if ($imageFileType == "png") {
      $myTempImage = imagecreatefrompng($_FILES["fileToUpload"]["tmp_name"]);
    }

    $imageW = imagesx($myTempImage); // gets image Witdh / laius
    $imageH = imagesy($myTempImage); // gets image Height / kõrgus

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

    $newThumbW = round($imageW / $imageSizeThumbRatio);
    $newThumbH = round($imageH / $imageSizeThumbRatio);
    $newNormalW = round($imageW / $imageSizeNormalRatio);
    $newNormalH = round($imageH / $imageSizeNormalRatio);

    // loome uue ajutise pildiobjekti
    // imagecreatetruecolor() returns an image identifier representing a black image of the specified size
    $myNewThumbImage = imagecreatetruecolor($newThumbW, $newThumbH);
    $myNewNormalImage = imagecreatetruecolor($newNormalW, $newNormalH);

    // imagecopyresampled() copies a rectangular portion of one image to another image, smoothly interpolating pixel values so that, in particular, reducing the size of an image still retains a great deal of clarity.
    imagecopyresampled($myNewThumbImage, $myTempImage, 0, 0, 0, 0, $newThumbW, $newThumbH, $imageW, $imageH);
    imagecopyresampled($myNewNormalImage, $myTempImage, 0, 0, 0, 0, $newNormalW, $newNormalH, $imageW, $imageH);


    // salvestame Thumb suurusega kujutise faili
    if ($imageFileType == "jpg") {
      if (imagejpeg($myNewThumbImage, $thumbPhotoDir . $fileName, 90)) {
        $thumbnotice = $warningStart . "Thumbnail pilt laeti üles!" . $warningEnd;
      } else {
        $thumberror = $warningStart . "Thumbnail pildi salvestamisel tekkis viga!" . $warningEnd;
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
      $error .= "Originaalpilt laeti üles!";
    } else {
      $notice .= "Pildi üleslaadimisel tekkis viga!";
    }

    // kustutame ajutised pildifailid
    imagedestroy($myTempImage);
    imagedestroy($myNewThumbImage);
    imagedestroy($myNewNormalImage);

  }
}