<?php

$sueArr = [];
$machineArr = ["children" => 3, "cats" => 7, "samoyeds" => 2, "pomeranians" => 3, "akitas" => 0, "vizslas" => 0, "goldfish" => 5, "trees" => 3, "cars" => 2, "perfumes" => 1];

$myfile = fopen("day16_input.txt", "r") or die("Unable to open file!");

while(!feof($myfile)) {
	$line = trim(fgets($myfile));

	$lineArr = explode(", ", $line);
	$sueNumArr = explode(": ", $lineArr[0]);
	$lineArr[0] = $sueNumArr[1].": ".$sueNumArr[2];

	foreach ($lineArr as $key => $value) {
		$thisArr = explode(": ", $value);
		$sueArr[substr($sueNumArr[0], 4)][$thisArr[0]] = intval($thisArr[1]);
	}	
}

fclose($myfile);

$correctNumber = 0;

foreach ($sueArr as $key => $value) {
	$correctValues = true;

	foreach ($value as $key2 => $value2) {
		if ($key2 == "cats" || $key2 == "trees") {
			if ($value2 <= $machineArr[$key2]) {
				$correctValues = false;
				break;
			}
		} elseif ($key2 == "pomeranians" || $key2 == "goldfish") {
			if ($value2 >= $machineArr[$key2]) {
				$correctValues = false;
				break;
			}
		} else {
			if ($value2 != $machineArr[$key2]) {
				$correctValues = false;
				break;
			}
		}
	}

	if ($correctValues) {
		$correctNumber = $key;
		break;
	}
}

echo ($correctNumber);

?>