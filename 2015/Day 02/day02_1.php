<?php

$totArea = 0;

$myfile = fopen("day2_input.txt", "r") or die("Unable to open file!");

while(!feof($myfile)) {
	$line = trim(fgets($myfile));
	
	$lineArr = array_map('intval', explode("x", $line));

	$areaArr = [];

	$areaArr[0] = $lineArr[0] * $lineArr[1];
	$areaArr[1] = $lineArr[0] * $lineArr[2];
	$areaArr[2] = $lineArr[1] * $lineArr[2];

	$thisArea = 0;
	$minUsed = false;

	foreach ($variable as $value) {
		if ($value == min($areaArr) && $minUsed == false) {
			$thisArea += 3*$value;
			$minUsed = true;
		} else {
			$thisArea += 2*$value;
		}
	}

	$totArea += $thisArea;
}

fclose($myfile);

echo($totArea);

?>