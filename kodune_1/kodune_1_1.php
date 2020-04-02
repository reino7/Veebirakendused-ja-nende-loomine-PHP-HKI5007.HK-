<?php

// abifunktsioonid
include 'helper.php';

// Loen etteantud kataloogist pildifailid juhuslikkuse alusel
// pildikataloog
$picsDir = "../pics/";
// lubatud failitüübid
$photoTypesAllowed = ["image/jpeg", "image/png"];
// tühi massiiv, kuhu lisatakse kataloogist saadud failid nimekirjana
$photoList = [];
// tühi massiiv, kuhu lisatakse loositud numbrid
$photoListExclude = [];
// kõik leitud failid / array lõikamine (lõikame kaustad (../) välja)
$allFiles = array_slice(scandir($picsDir), 2);

// massiivi läbikäimine ja lisame $photoListi saadud tulemused
foreach ($allFiles as $file) {

    $fileInfo = getimagesize($picsDir . $file);

    if (in_array($fileInfo["mime"], $photoTypesAllowed) == true) {
				array_push($photoList, $file);
    }

}

// loeb ära massiivi pikkuse
$photoCount = count($photoList);

// loome tsükli, mis käiakse läbi 3 korda
for ($i = 0; $i < 3; $i++) { 

	// käi läbi kood
	do {

		// juhusliku numbri valimine vastavalt 0 kuni numbrini palju pilte on kaustas
		$photoNum = mt_rand(0, $photoCount - 1);

		// kui $photoList[$photoNum] väärtusena antud pildi nime pole massiivis $photoListExclude,
		// siis lisa massiivi $photoListExclude pildi nimi
		if (in_array($photoList[$photoNum], $photoListExclude) == false) {

			array_push($photoListExclude, $photoList[$photoNum]);

		// kui $photoList[$photoNum] väärtuse nimega pilt on olemas, siis tee uus $photoNum väärtus,
		// ja lisa massiivi $photoListExclude pildi nimi
		} else {

			$photoNum = mt_rand(1, $photoCount - 1);
			array_push($photoListExclude, $photoList[$photoNum]);

		}
		
		// kui massiivis $photoListExclude on väärtus olemas, siis käivita kood kuni on tõene 
	} while (in_array($photoListExclude, $photoList) == true);
	
	// viime pildi HTML kuva $randomImageHTML väärtusesse
	$randomImageHTML = '<img src="' . $picsDir . $photoList[$photoNum] . '" height="300" alt="Juhuslik pilt Haapsalust">' . "\n";

	// kutsume välja $randomImageHTML väärtuse
	echo $randomImageHTML;

}




?>

<!DOCTYPE html>
<html lang="et">
<head>
	<meta charset="utf-8">
	<title>Veebirakendused ja nende loomine 2020</title>
</head>
<body>

<?php

	// massiivi loetavamaks tegemise/kuvamise funktsioonid
	// make_array_readable($photoList);
	// make_array_readable($photoListExclude);

?>

</body>
</html>