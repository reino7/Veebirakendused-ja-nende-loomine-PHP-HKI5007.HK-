<?php

class Photo {

  private $picToUpload;
  private $imageFileType;
  private $myTempImage; // originaalsuuruses pikslikogum
  public $myNewImage; // väiksem pikslikogum


  function __construct($picToUpload) {

    $this->picToUpload = $picToUpload;
    $this->imageFileType = $this->picToUpload["type"];

    // hiljem tuleks kõigepealt selgitada, kas on sobiv fail
    // üleslaadimiseks ja siis ka ImageFileType kindlaks teha
    $check = getimagesize($this->picToUpload["tmp_name"]);

    if ($check !== false) {

      // faili tüübi väljaselgitamine ja sobivuse kontroll
      if ($this->imageFileType == "image/jpeg") {
        $this->imageFileType = "jpg";
        echo $this->imageFileType;
      } elseif ($this->imageFileType == "image/png") {
        $this->imageFileType = "png";
        echo $this->imageFileType;
      } else {
        $error = "Ainult jpg/jpeg ja png pildid on lubatud! ";
      }

    } else {
      $error = "Valitud fail ei ole pilt! ";

      return $error;
    }

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


  public function saveImgToFile($target)  {
    
    $notice = null;

    if ($this->imageFileType == "jpg") {
      if (imagejpeg($this->myNewImage, $target, 90)) {
        $notice = 1;
      } else {
        $notice = 0;
      }
    }

    if ($this->imageFileType == "png") {
      if (imagepng($this->myNewImage, $target, 6)) {
        $notice = 1;
      } else {
        $notice = 0;
      }
    }

    imagedestroy($this->myNewImage);

    return $notice;

  }

  
  public function addWatermark($wmFile, $wmLocation, $fromEdge) {

    $wmFileType = strtolower(pathinfo($wmFile,PATHINFO_EXTENSION));
    //$waterMark = imagecreatefrompng($wmFile);
    $waterMark = $this->createImageFromFile($wmFile, $wmFileType);
    $waterMarkW = imagesx($waterMark);
    $waterMarkH = imagesy($waterMark);

    if($wmLocation == 1 or $wmLocation == 4){
      $waterMarkX = $fromEdge;
    }

    if($wmLocation == 2 or $wmLocation == 3){
      $waterMarkX = imagesx($this->myNewImage) - $waterMarkW - $fromEdge;
    }

    if($wmLocation == 1 or $wmLocation == 2){
      $waterMarkY = $fromEdge;
    }

    if($wmLocation == 3 or $wmLocation == 4){
      $waterMarkY = imagesy($this->myNewImage) - $waterMarkH - $fromEdge;
    }

    if($wmLocation == 5){
      $waterMarkX = round((imagesx($this->myNewImage) - $waterMarkW) / 2, 0);
      $waterMarkY = round((imagesy($this->myNewImage) - $waterMarkH) / 2, 0);
    }

    imagecopy($this->myNewImage, $waterMark, $waterMarkX, $waterMarkY, 0, 0, $waterMarkW, $waterMarkH);

  }//addWatermark lõppeb


  public function getEXIFInfo() {

    // kõige ees on "@" märk, et vältida hoiatust, kui ei õnnestu lugeda
    @$exif = exif_read_data($this->picToUpload["tmp_name"], "ANY_TAG", 0, true);
    
		if(!empty($exif["DateTimeOriginal"])){
			//kui sai lugeda, siis omistan pildistamise kuupäeva klassi muutujale
			$this->photoDate = $exif["DateTimeOriginal"];
		} else {
			$this->photoDate = NULL;
    }
    return $this->photoDate;
  }

} // klass lõppeb