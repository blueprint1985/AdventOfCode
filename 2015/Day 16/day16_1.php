<?php

$sueArr = [];
$machineArr = ["children: 3", "cats: 7", "samoyeds: 2", "pomeranians: 3", "akitas: 0", "vizslas: 0", "goldfish: 5", "trees: 3", "cars: 2", "perfumes: 1"];

$myfile = fopen("day16_input.txt", "r") or die("Unable to open file!");

while(!feof($myfile)) {
	$line = trim(fgets($myfile));

	$lineArr = explode(", ", $line);
	$sueNumArr = explode(": ", $lineArr[0]);

	$lineArr[0] = $sueNumArr[1].": ".$sueNumArr[2];
	$sueArr[substr($sueNumArr[0], 4)] = $lineArr;
}

fclose($myfile);

$correctNumber = 0;

foreach ($sueArr as $key => $value) {
	$correctValues = true;

	foreach ($value as $key2 => $value2) {
		if (!in_array($value2, $machineArr)) {
			$correctValues = false;
			break;
		}
	}

	if ($correctValues) {
		$correctNumber = $key;
		break;
	}
}

echo ($correctNumber);

?>