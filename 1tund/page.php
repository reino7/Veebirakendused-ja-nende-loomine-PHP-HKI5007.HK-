<?php

	include 'helper.php';

	$myName = "Reino1";
	$fullTimeNow = date("d.m.Y H:i:s");
	// <p>Lehe avamise hetkel oli: <strong>31.01.2020 11:32:07</strong></p>
	$timeHTML = "\n <p>Lehe avamise hetkel oli: <strong>" . $fullTimeNow . "</strong></p> \n";
	$hourNow = date("H");
	$partOfDay = "hägune aeg";
	// Kodune_1 #3 määran muutuja vaikeväärtused
	$partOfDayEveningBg = "f1f1f1";
	$partOfDayEveningFo = "000";

	if ($hourNow < 10) {
		$partOfDay = "hommik";
	} elseif ($hourNow >= 10 and $hourNow <= 18) {
		$partOfDay = "aeg aktiivselt tegutseda";
	} else {
		// Kodune_1 #3 Kui kell on peale 6-te õhtul, 
		// siis vahetab tausta- ja fondi värvi
		$partOfDay = "õhtu";
		$partOfDayEveningBg = "142634";
		$partOfDayEveningFo = "bdc7c1";	
		
	}


	$partOfDayHTML = "<p>Käes on " . $partOfDay . "!</p> \n";

	// info semestril kulgemise kohta
	$semesterStart = new DateTime("2020-01-27");
	$semesterEnd = new DateTime("2020-06-22");
	$semesterDuration = $semesterStart->diff($semesterEnd);
	// echo $semesterDuration;
	// var_dump($semesterDuration);
	$today = new DateTime("now");
	// $today = new DateTime("2020-03-30");
	$fromSemesterStart = $semesterStart->diff($today);


	// Kodune_1 #3

	// Kui tänane kuupäev on väiksem ja võrdne semestri alguskuupäevast
	if ($today <= $semesterStart) {
		echo "<p>Semester ei ole veel alanud. Start on " . $semesterStart->format("d.m.Y") .  "</p>";
	// Kui tänane kuupäev on väiksem ja võrdne semestri lõpukuupäevaga
	} elseif ($today <= $semesterEnd) {
			echo "<p>Semester on täies hoos juba " . 	$fromSemesterStart->format("%r%a") . " päeva </p>";
	// Muudel juhtudel on semester läbi. Väljastatakse kuupäev, millal läbi sai
	} else {
			echo "<p>Semester lõppes " . $semesterEnd->format("d.m.Y") . "</p>";
	}
	
	
	// <p>Semester on hoos: <meter min="0" max="147" value="4"></meter>.</p>
	// $semesterProgressHTML = '<p>Semester on hoos: <meter min="0" max="';
	// $semesterProgressHTML .= $semesterDuration->format("%r%a");
	// $semesterProgressHTML .= '" value="';
	// $semesterProgressHTML .= $semesterStart->format("%r%a");
	// $semesterProgressHTML .= '"> </meter></p>' . "\n";



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
	<style>
		body {
  		background-color: #<?php echo $partOfDayEveningBg ?>;
			color: #<?php echo $partOfDayEveningFo ?>;
		}
	</style>
</head>
<body>
	
	<h1><?php echo $myName ?></h1>
	<p>See leht on valminud õppetöö raames!</p>
	
	<?php 
		echo $timeHTML;
		echo $partOfDayHTML;
		// echo $semesterProgressHTML;
		echo $randomImageHTML;
	?>

</body>
</html>