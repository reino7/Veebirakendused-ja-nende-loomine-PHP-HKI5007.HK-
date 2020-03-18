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



  function readNews($data) {

    $response = null;

    // loon andmebaasi ühenduse
    $conn = new mysqli(
      $GLOBALS["serverHost"],
      $GLOBALS["serverUsername"],
      $GLOBALS["serverPassword"],
      $GLOBALS["database"]
    );
    

    $stmt = $conn->prepare("SELECT title, created, content FROM vr20_news WHERE deleted IS NULL ORDER BY created DESC LIMIT ?");
    echo $conn->error;
    $stmt->bind_param("s", $setNewsLimit);
    $setNewsLimit = $data;
    $stmt->bind_result($titleFromDB, $createdFromDB, $contentFromDB);
    $stmt->execute();
    // if($stmt->fetch())



    // h2 uudise pealkiri p uudis ise
    while ($stmt->fetch()) {

      // eraldan kuupäeva ja kellaja muutujast $createdFromDB
      $createdDate = substr($createdFromDB, 0, 10);
      $createdTime = substr($createdFromDB, 10);

      // muudan kuupäeva YYYY-MM-DD => DD-MM-YYYY ja asendan "-" -> "."
      $createdDate = date("d-m-Y", strtotime($createdDate));
      $createdDate = str_replace("-",".", $createdDate);

      // Uudise pealkiri
      $response .= '<div class="card mb-3"><div class="card-body"><h2>' . $titleFromDB .'</h2>';

      // Uudise lisamise kuupäev ja kellaaeg
      $response .= '<p class="text-muted">Uudis lisatud: ' . $createdDate . $createdTime . '</p>';
      // $response .= '<p class="text-muted">Uudis lisatud: ' . $createdFromDB . '</p>';

      // Uudise sisu
      $response .= '<p class="text-justify">' . $contentFromDB . '</p></div>
      </div>';
    }

    if($response == null) {
      $response = "<p>Kahjuks uudised puuduvad</p> \n";
    }

    // sulgen päringu ja andmebaasi ühenduse
    $stmt->close();
    $conn->close();

    return $response;
    
  }