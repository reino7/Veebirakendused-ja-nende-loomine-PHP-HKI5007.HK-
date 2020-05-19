<?php
	function readAllPrivatePictureThumbs(){ // readAllMyPictureThumbs
		$privacy = 1; // privaatne
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