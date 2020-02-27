<?php
    $myName = "Andrus Rinde";
    $fullTimeNow = date("d.m.Y H:i:s");
    //<p>Lehe avamise hetkel oli: <strong>31.01.2020 11:32:07</strong></p>
    $timeHTML = "\n <p>Lehe avamise hetkel oli: <strong>" .$fullTimeNow ."</strong></p> \n";
    $hourNow = date("H");
    $partOfDay = "hägune aeg";
    
    if($hourNow < 10){
        $partOfDay = "hommik";
    }
    if($hourNow >= 10 and $hourNow < 18){
        $partOfDay = "aeg aktiivselt tegutseda";
    }
    $partOfDayHTML = "<p>Käes on " .$partOfDay ."!</p> \n";
    
    //info semestri kulgemise kohta
    $semesterStart = new DateTime("2020-1-27");
    $semesterEnd = new DateTime("2020-6-22");
    $semesterDuration = $semesterStart->diff($semesterEnd);
    //echo $semesterDuration;
    //var_dump($semesterDuration);
    $today = new DateTime("now");
    $fromSemesterStart = $semesterStart->diff($today);
    if($fromSemesterStart->format("%r%a") < 0){
		$semesterProgressHTML = "<p>Semester pole veel alanud!</p> \n";
	} elseif ($fromSemesterStart->format("%r%a") <= $semesterDuration->format("%r%a")){
		//<p>Semester on hoos: <meter min="0" max="147" value="4"></meter>.</p>
		$semesterProgressHTML = '<p>Semester on hoos: <meter min="0" max="';
		$semesterProgressHTML .= $semesterDuration->format("%r%a");
		$semesterProgressHTML .= '" value="';
		$semesterProgressHTML .= $fromSemesterStart->format("%r%a");
		$semesterProgressHTML .= '"></meter>.</p>' ."\n";
	} else {
		$semesterProgressHTML = "<p>Semester on lõppenud!</p> \n";
	}
    
    //loen etteantud kataloogist pildifailid
    $picsDir = "../../pics/";
    $photoTypesAllowed = ["image/jpeg", "image/png"];
    $photoList = [];
    $allFiles = array_slice(scandir($picsDir), 2);
    //var_dump($allFiles);
    foreach($allFiles as $file){
        $fileInfo = getimagesize($picsDir .$file);
        if(in_array($fileInfo["mime"], $photoTypesAllowed) == true){
            array_push($photoList, $file);
        }
    }
    
    $photoCount = count($photoList);
    //$photoNum = mt_rand(0, $photoCount - 1);
    //$randomImageHTML = '<img src="' .$picsDir .$photoList[$photoNum] .'" alt="juhuslik pilt Haapsalust">' ."\n";
	
	$photosToShow = [];
	$photoCountLimit = 3;
	if($photoCount < 3){
		$photoCountLimit = $photoCount;
	}
	for ($i = 0; $i < $photoCountLimit; $i ++){
		do {
			$photoNum = mt_rand(0, ($photoCount - 1));
		} while (in_array($photoNum, $photosToShow) == true);
		array_push($photosToShow, $photoNum);
	}
	$randomImageHTML = "";
	for($i = 0; $i < count($photosToShow); $i++){
		$randomImageHTML .= '<img src="' .$picsDir .$photoList[$photosToShow[$i]] .'" alt="juhuslik pilt Haapsalust">' ."\n";
	}
	
	//kellaajast sõltuv värvi osa
	$bgColor = "#FFFFFF";
	$txtColor = "#000000";
	if($hourNow > 21 or $hourNow < 7){
		$bgColor = "#000033";
		$txtColor = "#FFFFEE";
	} elseif ($hourNow >= 7 and $hourNow < 12){
		$bgColor = "#FFFFEE";
		$txtColor = "#000033";
	} elseif ($hourNow >= 12 and $hourNow < 18){
		$bgColor= "#FFFFFF";
		$txtColor = "#000066";
	} else {
		$bgColor = "#999999";
		$txtColor = "#000033";
	}
	$styleHTML = "<style> \n .timeBackground { \n background-color: ";
	$styleHTML .= $bgColor;
	$styleHTML .= "; \n color: ";
	$styleHTML .= $txtColor;
	$styleHTML .= "; \n } \n </style> \n";
    
?>
<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
	<title>Veebirakendused ja nende loomine 2020</title>
	<?php
		echo $styleHTML;
	?>
</head>
<body>
	<h1 class="timeBackground"><?php echo $myName; ?></h1>
	<p>See leht on valminud õppetöö raames!</p>
    <?php
        echo $timeHTML;
        echo $partOfDayHTML;
        echo $semesterProgressHTML;
        echo $randomImageHTML;
    ?>
	<br>
	<hr>
	<!--<img src="imagedelivery.php?pic=IMG_6770.JPG" alt="paremini esitletud pilt">-->
</body>
</html>