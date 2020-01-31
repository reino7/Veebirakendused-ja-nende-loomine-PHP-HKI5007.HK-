<?php

	$myName = "Reino1";
	$fullTimeNow = date("d.m.Y H:i:s");
	// <p>Lehe avamise hetkel oli: <strong>31.01.2020 11:32:07</strong></p>
	$timeHTML = "\n <p>Lehe avamise hetkel oli: <strong>" . $fullTimeNow . "</strong></p> \n";
	$hourNow = date("H");
	$partOfDay = "hägune aeg";

	if ($hourNow < 10) {
		$partOfDay = "hommik";
	}

	if ($hourNow >= 10 and $hourNow < 18) {
		$partOfDay = "aeg aktiivselt tegutseda";
	}

	$partOfDayHTML = "<p>Käes on " . $partOfDay . "!</p> \n";

	// info semestril kulgemise kohta
	$semesterStart = new DateTime("2020-01-27");
	$semesterEnd = new DateTime("2020-06-22");
	$semesterDuration = $semesterStart->diff($semesterEnd);
	// echo $semesterDuration;
	// var_dump($semesterDuration);
	$today = new DateTime("now");
	$fromSemesterStart = $semesterStart->diff($today);

	// <p>Semester on hoos: <meter min="0" max="147" value="4"></meter>.</p>
	$semesterProgressHTML = '<p>Semester on hoos: <meter min="0" max="';
	$semesterProgressHTML .= $semesterDuration->format("%r%a");
	$semesterProgressHTML .= '" value="';
	$semesterProgressHTML .= $semesterStart->format("%r%a");
	$semesterProgressHTML .= '"> </meter></p>' . "\n";

	// Koduseks tööks IF kas semester on alanud ja ka lõppenud

	// Loen etteantud kataloogist pildifailid juhuslikkuse alusel
	// pildikataloog
	$picsDir = "../pics/";
	// lubatud failitüübid
	$photoTypesAllowed = ["image/jpeg", "image/png"];
	// tühi massiiv, kuhu lisatakse kataloogist saadud failid nimekirjana
	$photoList = [];
	// kõik leitud failid / array lõikamine (lõikame kaustad (../) välja)
	$allFiles = array_slice(scandir($picsDir), 2);
	// var_dump($allFiles);

	// massiivi läbikäimine ja lisame $photoListi saadud tulemused
	foreach ($allFiles as $file) {
		
		$fileInfo = getimagesize($picsDir .$file);

		if(in_array($fileInfo["mime"], $photoTypesAllowed) == true) {
			array_push($photoList, $file);
		}
		
	}

	$photoCount = count($photoList);
	// juhusliku numbri valimine
	$photoNum = mt_rand(0, $photoCount - 1);
	$randomImageHTML = '<img src="'. $picsDir . $photoList[$photoNum] . '" alt="Juhuslik pilt Haapsalust">' . "\n";



?>

<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
	<title>Veebirakendused ja nende loomine 2020</title>
</head>
<body>
	
	<h1><?php echo $myName ?></h1>
	<p>See leht on valminud õppetöö raames!</p>
	
	<?php 
		echo $timeHTML;
		echo $partOfDayHTML;
		echo $semesterProgressHTML;
		echo $randomImageHTML;
	?>

</body>
</html>