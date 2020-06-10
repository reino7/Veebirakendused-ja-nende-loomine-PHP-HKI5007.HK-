<?php

  // Database variables
  $serverUserName = "";
  $serverPassword = "";
  $serverHost = "";
  $database = "";

  // Uploaded photos location variables
  $originalPhotoDir    = "uploadOriginalPhoto/";
  $normalPhotoDir      = "uploadNormalPhoto/";
  $thumbPhotoDir       = "uploadThumbPhoto/";

  // Watermark variables
  $wmFile = "watermark/vr_rr.png";
  // Väsimärgi asukoht
  // 1 vasak üleval, 2 paremal üleval, 3 all paremal, 4 all vasakul
  $wmLocation = "2"; 
  // kaugus servast pikslites
  $fromEdge = 10;