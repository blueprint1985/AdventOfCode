<?php

$totLen = 0;

$myfile = fopen("day2_input.txt", "r") or die("Unable to open file!");

while(!feof($myfile)) {
	$line = trim(fgets($myfile));
	
	$lineArr = array_map('intval', explode("x", $line));

	$thisLen = 0;
	$maxUsed = false;

	foreach ($lineArr as $value) {
		if ($value == max($lineArr) && $maxUsed == false) {
			$maxUsed = true;
		} else {
			$thisLen += 2*$value;
		}
	}

	$thisLen += $lineArr[0]*$lineArr[1]*$lineArr[2];

	$totLen += $thisLen;
}

fclose($myfile);

echo($totLen);

?>