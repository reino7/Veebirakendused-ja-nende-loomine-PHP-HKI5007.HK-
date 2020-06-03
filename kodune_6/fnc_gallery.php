<?php
	function readAllPrivatePictureThumbs(){ // readAllMyPictureThumbs
		$privacy = 1; // privaatne
		$finalHTML = "";
		$html = "";

		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUserName"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("SELECT filename, alttext FROM vr20_photos WHERE userid=? AND deleted IS NULL ORDER BY id LIMIT ?,?");
		echo $conn->error;

		$stmt->bind_param("iii", $_SESSION["userid"], $_GET["offset"], $_GET["limit"]);
		$stmt->bind_result($filenameFromDb, $altFromDb);
		$stmt->execute();

		while($stmt->fetch()){
			// $html .= '<a href="' .$GLOBALS["normalPhotoDir"] .$filenameFromDb .'" target="_blank"><img src="' .$GLOBALS["thumbPhotoDir"] .$filenameFromDb .'" alt="'.$altFromDb .'"></a>' ."\n \t \t";
			$html .= '
			<div class="col-3">
				<a href="' .$GLOBALS["normalPhotoDir"] .$filenameFromDb .'" data-lightbox="MinuPildid" data-title="'.$altFromDb .'" class="d-block mb-3 h-100 text-decoration-none">
					<img class="img-fluid img-thumbnail" src="' .$GLOBALS["thumbPhotoDir"] .$filenameFromDb .'" alt="'.$altFromDb .'">
					<small class="form-text text-muted">'. $altFromDb .'</small>
				</a>
			</div>
		' ."\n";
		}

		if($html != ""){
			$finalHTML = $html;
		} else {
			$finalHTML = '<p><img src="img/no-photos.png" height="128"></p><div class="alert alert-warning w-25" role="alert">Kahjuks pilte pole! <br>Lisa <a href="photoUpload.php" alt="Foto lisamine">siit</a></div>';
		}
		
		$stmt->close();
		$conn->close();

		return $finalHTML;
	}


	function readAllSignInUsersPictureThumbs(){ // readAllMyPictureThumbs

		$privacy = 2; // Sisseloginud kasutajatele
		$finalHTML = "";
		$html = "";

		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUserName"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("SELECT filename, alttext FROM vr20_photos WHERE userid=? AND deleted IS NULL");
		echo $conn->error;
		
		$stmt->bind_param("i", $_SESSION["userid"]);
		$stmt->bind_result($filenameFromDb, $altFromDb);
		$stmt->execute();

		while($stmt->fetch()){
			// $html .= '<a href="' .$GLOBALS["normalPhotoDir"] .$filenameFromDb .'" target="_blank"><img src="' .$GLOBALS["thumbPhotoDir"] .$filenameFromDb .'" alt="'.$altFromDb .'"></a>' ."\n \t \t";
			$html .= '
			<div class="col-3">
				<a href="' .$GLOBALS["normalPhotoDir"] .$filenameFromDb .'" data-lightbox="MinuPildid" data-title="'.$altFromDb .'" class="d-block mb-3 h-100 text-decoration-none">
					<img class="img-fluid img-thumbnail" src="' .$GLOBALS["thumbPhotoDir"] .$filenameFromDb .'" alt="'.$altFromDb .'">
					<small class="form-text text-muted">'. $altFromDb .'</small>
				</a>
			</div>
		' ."\n";
		}

		if($html != ""){
			$finalHTML = $html;
		} else {
			$finalHTML = '<p><img src="img/no-photos.png" height="128"></p><div class="alert alert-warning w-25" role="alert">Kahjuks pilte pole! <br>Lisa <a href="photoUpload.php" alt="Foto lisamine">siit</a></div>';
		}
		
		$stmt->close();
		$conn->close();

		return $finalHTML;
	}


	function readAllPublicPictureThumbs(){ //readAllSemiPublicPictureThumbs

		$privacy = 3; // avalik
		$finalHTML = "";
		$html = "";

		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUserName"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("SELECT filename, alttext FROM vr20_photos WHERE privacy<=? AND deleted IS NULL");
		echo $conn->error;
		
		$stmt->bind_param("i", $privacy);
		$stmt->bind_result($filenameFromDb, $altFromDb);
		$stmt->execute();

		while($stmt->fetch()){
			$html .= '
			<div class="col-3">
				<a href="' .$GLOBALS["normalPhotoDir"] .$filenameFromDb .'" data-lightbox="MinuPildid" data-title="'.$altFromDb .'" class="d-block mb-3 h-100 text-decoration-none">
					<img class="img-fluid img-thumbnail" src="' .$GLOBALS["thumbPhotoDir"] .$filenameFromDb .'" alt="'.$altFromDb .'">
					<small class="form-text text-muted">'. $altFromDb .'</small>
				</a>
			</div>
		' ."\n";
		}

		if($html != ""){
			$finalHTML = $html;
		} else {
			$finalHTML = '<p><img src="img/no-photos.png" height="128"></p><div class="alert alert-warning w-25" role="alert">Kahjuks pilte pole! <br>Lisa <a href="photoUpload.php" alt="Foto lisamine">siit</a></div>';
		}

		$stmt->close();
		$conn->close();

		return $finalHTML;

	 }


	function countPics($privacy)
	{
		$notice = null;

		$conn   = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUserName"], $GLOBALS["serverPassword"], $GLOBALS["database"]);

		$stmt   = $conn->prepare("SELECT COUNT(id) FROM vr20_photos WHERE privacy<=? AND deleted IS NULL");
		echo $conn->error;
		
		$stmt->bind_param("i", $privacy);
		$stmt->bind_result($count);
		$stmt->execute();
		$stmt->fetch();
		$notice = $count;

		$stmt->close();
		$conn->close();

		return $notice;
	}


	function readAllSemiPublicPictureThumbsPage($page, $limit){
		$privacy = 2;
		$skip = $page * $limit;
		$finalHTML = "";
		$html = "";
		$conn = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUserName"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		//$stmt = $conn->prepare("SELECT filename, alttext FROM vr20_photos WHERE privacy<=? AND deleted IS NULL LIMIT ?,?");
		$stmt = $conn->prepare("SELECT vr20_photos.filename, vr20_photos.alttext, vr20_users.firstname, vr20_users.lastname FROM vr20_photos JOIN vr20_users on vr20_users.id = vr20_photos.userid WHERE vr20_photos.privacy<=? AND vr20_photos.deleted");
		//$stmt = $conn->prepare("SELECT vr20_photos.Id, vr20_photos.filename, vr20_photos.alttext, vr20_users.firstname, vr20_users.lastname FROM vr20_photos JOIN vr20_users on vr20_users.id = vr20_photos.userid WHERE vr20_photos.privacy<=? AND vr20_photos.deleted");
		echo $conn->error;
		$stmt->bind_param("iii", $privacy, $skip, $limit);
		$stmt->bind_result($filenameFromDb, $altFromDb, $firstnameFromBb, $lastnameFromDb);
		$stmt->execute();
		while($stmt->fetch()){
			$html .= '<div class="galleryelement">' ."\n";
			//$html .= '<a href="' .$GLOBALS["normalPhotoDir"] .$filenameFromDb .'" target="_blank"><img src="' .$GLOBALS["thumbPhotoDir"] .$filenameFromDb .'" alt="'.$altFromDb .'" class="thumb"></a>' ."\n \t \t";
			$html .= '<img src="' .$GLOBALS["thumbPhotoDir"] .$filenameFromDb .'" alt="'.$altFromDb .'" class="thumb" data-fn="' .$filenameFromDb .'" data-id="'.$idFromDb . '">' ."\n \t \t";
			$html .= "<p>" .$firstnameFromBb ."</p> \n \t \t";
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