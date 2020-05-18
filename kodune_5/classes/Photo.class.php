<?php

class Photo {

  private $picToUpload;
  private $imageFileType;
  private $myTempImage; // originaalsuuruses pikslikogum
  public $myNewImage; // väiksem pikslikogum


  function __construct($picToUpload, $imageFileType) {

    $this->picToUpload = $picToUpload;
    $this->imageFileType = $imageFileType;

    // hiljem tuleks kõigepealt selgitada, kas on sobiv fail
    // üleslaadimiseks ja siis ka ImageFileType kindlaks teha

    $this->myTempImage = $this->createImageFromFile($this->picToUpload["tmp_name"], $this->imageFileType);

  }


  function __destruct() {

    if (isset($this->myTempImage)) {
      imagedestroy($this->myTempImage);
    }

    if (isset($this->myNewImage)) {
      @imagedestroy($this->myNewImage);
    }
    
  }
  
  
  function createImageFromFile($imageFile, $fileType) {

    if ($fileType == "jpg") {
      $image = imagecreatefromjpeg($imageFile);
    }

    if ($fileType == "png") {
      $image = imagecreatefrompng($imageFile);
    }

    return $image;

  }


  public function resizePhoto($w, $h, $keepOrigProportion = true)  {

    $imageW   = imagesx($this->myTempImage);
    $imageH   = imagesy($this->myTempImage);
    $newW     = $w;
    $newH     = $h;
    $cutX     = 0;
    $cutY     = 0;
    $cutSizeW = $imageW;
    $cutSizeH = $imageH;
  
    if ($w == $h) {
      if ($imageW > $imageH) {
        $cutSizeW = $imageH;
        $cutX     = round(($imageW - $cutSizeW) / 2);
      } else {
        $cutSizeH = $imageW;
        $cutY     = round(($imageH - $cutSizeH) / 2);
      }
    } elseif ($keepOrigProportion) { //kui tuleb originaaproportsioone säilitada
      if ($imageW / $w > $imageH / $h) {
        $newH = round($imageH / ($imageW / $w));
      } else {
        $newW = round($imageW / ($imageH / $h));
      }
    } else { //kui on vaja kindlasti etteantud suurust, ehk pisut ka kärpida
      if ($imageW / $w < $imageH / $h) {
        $cutSizeH = round($imageW / $w * $h);
        $cutY     = round(($imageH - $cutSizeH) / 2);
      } else {
        $cutSizeW = round($imageH / $h * $w);
        $cutX     = round(($imageW - $cutSizeW) / 2);
      }
    }
  
    //loome uue ajutise pildiobjekti
    $this->myNewImage = imagecreatetruecolor($newW, $newH);

    //kui on läbipaistvusega png pildid, siis on vaja säilitada läbipaistvusega
    imagesavealpha($this->myNewImage, true);
    $transColor = imagecolorallocatealpha($this->myNewImage, 0, 0, 0, 127);
    imagefill($this->myNewImage, 0, 0, $transColor);
    imagecopyresampled($this->myNewImage, $this->myTempImage, 0, 0, $cutX, $cutY, $newW, $newH, $cutSizeW, $cutSizeH);
    
  }
  
} // klass lõppeb