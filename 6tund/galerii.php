<?php
	require("classes/Session.class.php");
	SessionManager::sessionStart("vr20", 0, "/~reino.ristissaar/", "tigu.hk.tlu.ee");
	
	//kas pole sisseloginud
	if(!isset($_SESSION["userid"])){
		//jõuga avalehele
		header("Location: page.php");
	}
	
	//login välja
	if(isset($_GET["logout"])){
		session_destroy();
		header("Location: page.php");
	}

	require("db/configuration.php");
	
function readAllSemiPublicPictureThumbsPage(){
		$privacy = 2;
		//$skip = $page * $limit;
		$finalHTML = "";
		$html = "";
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUserName"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		//$stmt = $conn->prepare("SELECT filename, alttext FROM vr20_photos WHERE privacy<=? AND deleted IS NULL LIMIT ?,?");
		$stmt = $conn->prepare("SELECT vr20_photos.filename, vr20_photos.alttext, vr20_users.firstname, vr20_users.lastname FROM vr20_photos JOIN vr20_users on vr20_users.id = vr20_photos.userid WHERE vr20_photos.privacy<=? AND vr20_photos.deleted IS NULL");

		//  keskmise väärtuse lisamine kohe pildile koos nimega
		// SELECT vr20_photos.id, vr20_users.firstname, vr20_users.lastname, vr20_photos.filename, vr20_photos.alttext, AVG(vr20_photoratings.rating) as AvgValue FROM vr20_photos JOIN vr20_users ON vr20_photos.userid = vr20_users.id LEFT JOIN vr20_photoratings ON vr20_photoratings.photoid = vr20_photos.id WHERE vr20_photos.privacy <= ? AND deleted IS NULL GROUP BY vr20_photos.id DESC LIMIT ?, ?

		echo $conn->error;
		$stmt->bind_param("i", $privacy);
		$stmt->bind_result($filenameFromDb, $altFromDb, $firstnameFromBb, $lastnameFromDb);
		$stmt->execute();
		while($stmt->fetch()){
			$html .= '<div class="galleryelement">' ."\n";
			//$html .= '<a href="' .$GLOBALS["normalPhotoDir"] .$filenameFromDb .'" target="_blank"><img src="' .$GLOBALS["thumbPhotoDir"] .$filenameFromDb .'" alt="'.$altFromDb .'" class="thumb"></a>' ."\n \t \t";
			$html .= '<img src="' .$GLOBALS["thumbPhotoDir"] .$filenameFromDb .'" alt="'.$altFromDb .'" class="thumb" data-fn="' .$filenameFromDb .'">' ."\n \t \t";
			$html .= "<p>" .$firstnameFromBb ." " .$lastnameFromDb ."</p> \n \t \t";
			$html .= "</div> \n \t \t";
		}
		if($html != ""){
			$finalHTML = $html;
		} else {
			$finalHTML = "<p>Kahjuks pilte pole!</p>";
		}
		$stmt->close();
		$conn->close();
		return $finalHTML;
	}
	
	//require("fnc_gallery.php");
	
	$gallery = readAllSemiPublicPictureThumbsPage();
?>
<!DOCTYPE html>
<html lang="et">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Veebirakendused ja nende loomine 2020</title>
  <link rel="stylesheet" type="text/css" href="style/gallery.css">
  <link rel="stylesheet" type="text/css" href="style/modal.css">
  <script src="javascript/modal.js" defer></script>
</head>

<body>

  <div id="modalArea" class="modalArea">
    <!--Sulgemisnupp-->
    <span id="modalClose" class="modalClose">&times;</span>
    <!--pildikoht-->
    <div class="modalHorizontal">
      <div class="modalVertical">
        <p id="modalCaption"></p>
        <img src="empty.png" id="modalImg" class="modalImg" alt="galeriipilt">
        <br>

        <div id="rating" class="modalRating">
          <label><input id="rate1" name="rating" type="radio" value="1">1</label>
          <label><input id="rate2" name="rating" type="radio" value="2">2</label>
          <label><input id="rate3" name="rating" type="radio" value="3">3</label>
          <label><input id="rate4" name="rating" type="radio" value="4">4</label>
          <label><input id="rate5" name="rating" type="radio" value="5">5</label>
          <button id="storeRating">Salvesta hinnang!</button>
          <br>
          <p id="avgRating"></p>
        </div>

      </div>
    </div>
  </div>

  <h1>Kasutajate avaldatavad pildid</h1>
  <p>See leht on valminud õppetöö raames!</p>
  <p><?php echo $_SESSION["userFirstName"]; ?> Logi <a href="?logout=1">välja</a>!</p>
  <p>Tagasi <a href="home.php">avalehele</a>!</p>
  <hr>

  <div class="gallery" id="gallery">
    <?php echo $gallery; ?>
  </div>
  <hr>
</body>

</html>