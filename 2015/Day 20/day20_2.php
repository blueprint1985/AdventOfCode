<?php

function getDivisors($num) {

	$start = 1;
	$end = intval($num);
	$sqrtEnd = sqrt($end);

	$divisors = [];

	for ($i = $start; $i <= $sqrtEnd; $i++) { 
		if ($end % $i == 0) {
			$divisors[] = $i;
			$divisors[] = $end / $i;
		}
	}

	return array_unique($divisors);
}

$myfile = fopen("day20_input.txt", "r") or die("Unable to open file!");

$line = intval(trim(fgets($myfile)));

fclose($myfile);

$corrHouse = 0;
$elfCounter = [];

for ($i = 1; $i <= $line/10; $i++) { 
	$divisors = getDivisors($i);

	foreach ($divisors as $key => $value) {
		if (isset($elfCounter[$value])) {
			if ($elfCounter[$value] >= 50) unset($divisors[$key]);
		}
	}

	$houseSum = array_sum($divisors) * 11;

	if ($houseSum >= $line) {
		$corrHouse = $i;
		break;
	}

	foreach ($divisors as $key => $value) {
		if (!isset($elfCounter[$value])) $elfCounter[$value] = 1;
		else $elfCounter[$value]++;
	}
}

echo $corrHouse;

?>