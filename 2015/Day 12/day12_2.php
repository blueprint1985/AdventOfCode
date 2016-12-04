<?php

function sumNumbers($inputFile) {
	$sum = 0;

	foreach($inputFile as $value) {
		if (is_object($value)) {
			$ignoreVal = in_array("red", (array)$value, true);
			if ($ignoreVal === false) $sum += sumNumbers($value);
		}

		if (is_array($value)) $sum += sumNumbers($value);
		if (is_numeric($value)) $sum += $value;
	}

	return $sum;
}

$myfile = fopen("day12_input.txt", "r") or die("Unable to open file!");

$line = trim(fgets($myfile));

fclose($myfile);

$encodedLine = json_decode($line);

echo (sumNumbers($encodedLine));

?>