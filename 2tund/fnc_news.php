<?php

  function saveNews($newsTitle, $newsContent) {

    $response = null;

    // loon andmebaasi ühenduse
    $conn = new mysqli(
      $GLOBALS["serverHost"],
      $GLOBALS["serverUsername"],
      $GLOBALS["serverPassword"],
      $GLOBALS["database"]
    );
  
    // valmistan ette SQL päringu
    // stmt - statement
    $stmt = $conn->prepare("INSERT INTO vr20_news (userid, title, content) VALUES (?, ?, ?)");

    echo $conn->error;

    // seon päringuga tegelikud andmed
    $userid = 1;
    // i-integer, s-string, d-decimal
    $stmt->bind_param("iss", $userid, $newsTitle, $newsContent);

    // kui viga, siis kuva veateade
    if($stmt->execute()) {
      $response = 1;
    } else {
      $response = 0;
      echo $stmt->error;
    }

    // sulgen päringu ja andmebaasi ühenduse
    $stmt->close();
    $conn->close();

    return $response;

  }



  function readNews() {

    $response = null;

    // loon andmebaasi ühenduse
    $conn = new mysqli(
      $GLOBALS["serverHost"],
      $GLOBALS["serverUsername"],
      $GLOBALS["serverPassword"],
      $GLOBALS["database"]
    );
    
    $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

    if (strpos($url,'latestnews') !== false) {
        $stmt = $conn->prepare("SELECT title, content FROM vr20_news ORDER BY created DESC LIMIT 5");
    } else {
      $stmt = $conn->prepare("SELECT title, content FROM vr20_news ORDER BY created DESC");
    }

    //$stmt = $conn->prepare("SELECT title, content FROM vr20_news ORDER BY created DESC");
    echo $conn->error;
    $stmt->bind_result($titleFromDB, $contentFromDB);
    $stmt->execute();
    // if($stmt->fetch())

    // h2 uudise pealkiri p uudis ise
    while ($stmt->fetch()) {
      $response .= "<h2>" . $titleFromDB . "</h2> \n";
      $response .= "<p>" . $contentFromDB . "</p> \n";
    }

    if($response == null) {
      $response = "<p>Kahjuks uudised puuduvad</p> \n";
    }

    // sulgen päringu ja andmebaasi ühenduse
    $stmt->close();
    $conn->close();

    return $response;
    
  }