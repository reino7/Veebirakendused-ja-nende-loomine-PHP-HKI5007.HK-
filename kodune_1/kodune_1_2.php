<?php

// abifunktsioonid
include 'helper.php';

$fullTimeNow = date("d.m.Y H:i:s");
// <p>Lehe avamise hetkel oli: <strong>31.01.2020 11:32:07</strong></p>
$timeHTML = "\n <p>Lehe avamise hetkel oli: <strong>" . $fullTimeNow . "</strong></p> \n";
$hourNow = date("H");
$partOfDay = "hägune aeg";

// Kodune_1 #3 määran muutuja vaikeväärtused
$partOfDayBg = "f1f1f1";
$partOfDayFo = "000";


if ($hourNow < 10) {

	$partOfDay = "hommik";

} elseif ($hourNow >= 10 and $hourNow <= 18) {

		$partOfDay = "aeg aktiivselt tegutseda";

} else {
	
	// Kodune_1 #3 Kui kell on peale 6-te õhtul,
    // siis vahetab tausta- ja fondi värvi
    $partOfDay = "õhtu";
    $partOfDayBg = "142634";
    $partOfDayFo = "bdc7c1";

}

$partOfDayHTML = "<p>Käes on " . $partOfDay . "!</p> \n";

?>

<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
	<title>Veebirakendused ja nende loomine 2020</title>
	<style>
		body {
  		background-color: #<?php echo $partOfDayBg ?>;
			color: #<?php echo $partOfDayFo ?>;
		}
	</style>
</head>
<body>

	<!-- <h1><?php echo $myName ?></h1> -->
	<!-- <p>See leht on valminud õppetöö raames!</p> -->

	<?php
		echo $timeHTML;
		echo $partOfDayHTML;
		// echo $semesterProgressHTML;
	?>

</body>
</html>