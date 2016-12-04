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

for ($i = 1; $i <= $line/10; $i++) { 
	$divisors = getDivisors($i);
	$houseSum = array_sum($divisors) * 10;

	if ($houseSum >= $line) {
		$corrHouse = $i;
		break;
	}
}

echo $corrHouse;

?>