<?php

// abifunktsioonid
include 'helper.php';

$fullTimeNow = date("d.m.Y H:i:s");
// <p>Lehe avamise hetkel oli: <strong>31.01.2020 11:32:07</strong></p>
$timeHTML = "\n <p>Lehe avamise hetkel oli: <strong>" . $fullTimeNow . "</strong></p> \n";
$hourNow = date("H");
$partOfDay = "hägune aeg";

// info semestril kulgemise kohta
$semesterStart = new DateTime("2020-01-27");
$semesterEnd = new DateTime("2020-06-22");
$semesterDuration = $semesterStart->diff($semesterEnd);
// echo $semesterDuration;
// var_dump($semesterDuration);

// hetke kuupäeva määramine
// tänane kuupäev vastavalt kalendrile
$today = new DateTime("now");
// Määran ise kuupäeva, hea variant testimiseks, kommenteeri välja
// $today = new DateTime("2020-01-15");
// $today = new DateTime("2020-08-15");
$fromSemesterStart = $semesterStart->diff($today);

// Kui tänane kuupäev on väiksem ja võrdne semestri alguskuupäevast
if ($today <= $semesterStart) {
    $semesterHTML = "<p>Semester ei ole veel alanud. Start on " . $semesterStart->format("d.m.Y") . "</p>";
    // Kui tänane kuupäev on väiksem ja võrdne semestri lõpukuupäevaga
} elseif ($today <= $semesterEnd) {
    $semesterHTML = "<p>Semester on täies hoos juba " . $fromSemesterStart->format("%r%a") . " päeva </p>";
    // Muudel juhtudel on semester läbi. Väljastatakse kuupäev, millal läbi sai
} else {
    $semesterHTML = "<p>Semester lõppes " . $semesterEnd->format("d.m.Y") . "</p>";
}

// <p>Semester on hoos: <meter min="0" max="147" value="4"></meter>.</p>
// $semesterProgressHTML = '<p>Semester on hoos: <meter min="0" max="';
// $semesterProgressHTML .= $semesterDuration->format("%r%a");
// $semesterProgressHTML .= '" value="';
// $semesterProgressHTML .= $semesterStart->format("%r%a");
// $semesterProgressHTML .= '"> </meter></p>' . "\n";

?>

<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
	<title>Veebirakendused ja nende loomine 2020</title>
</head>
<body>

	<?php
		echo $timeHTML;
		echo $semesterHTML;
		// echo $semesterProgressHTML;
 	?>

</body>
</html>