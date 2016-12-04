<?php

ini_set('memory_limit', '-1');

// Not my function, fount it at http://www.needcodefor.com/php/php-function-to-generate-all-permutations/
function permutations($set) {
	$solutions = array();
	$n = count($set);
	$p = array_keys($set);
	$i = 1;
 
	while ($i<$n) {
		if ($p[$i]>0) {
			$p[$i]--;
			$j=0;
			if ($i%2==1) $j=$p[$i];
			//swap
			$tmp=$set[$j];
			$set[$j]=$set[$i];
			$set[$i]=$tmp;
			$i=1;
			$solutions[]=$set;
		} elseif ($p[$i]==0) {
			$p[$i]=$i;
			$i++;
		}
	}

	return $solutions;
}

function calcTable($gainLose, $currTable) {
	$totHappiness = 0;

	foreach ($currTable as $key => $value) {
		if ($key == 0) {
			$sitLeft = $currTable[count($currTable)-1];
			$sitRight = $currTable[$key+1];
		} elseif ($key == count($currTable)-1) {
			$sitLeft = $currTable[$key-1];
			$sitRight = $currTable[0];
		} else {
			$sitLeft = $currTable[$key-1];
			$sitRight = $currTable[$key+1];
		}

		foreach ($gainLose as $key2 => $value2) {
			if ($value2[0] == $value && $value2[2] == $sitLeft) $totHappiness += $value2[1];
			if ($value2[0] == $value && $value2[2] == $sitRight) $totHappiness += $value2[1];
		}
	}

	return $totHappiness;
}


$gainLoseArr = [];

$myfile = fopen("day13_input.txt", "r") or die("Unable to open file!");

while(!feof($myfile)) {
	$line = trim(fgets($myfile));

	$lineArr = explode(" ", $line);

	if ($lineArr[2] == "lose") {
		$gainLoseArr[] = [$lineArr[0], "-".$lineArr[3], trim($lineArr[10], ".")];
	} else {
		$gainLoseArr[] = [$lineArr[0], $lineArr[3], trim($lineArr[10], ".")];
	}
}

fclose($myfile);

$nameArray = [];

foreach ($gainLoseArr as $value) {
	if (!in_array($value[0], $nameArray)) $nameArray[] = $value[0];
}

foreach ($nameArray as $value) {
	$gainLoseArr[] = ["Martin", 0, $value];
	$gainLoseArr[] = [$value, 0, "Martin"];
}

$nameArray[] = "Martin";

$possibleSeatArr = permutations(array_values($nameArray));

$totHappinessArr = [];

foreach ($possibleSeatArr as $key => $value) {
	$totHappinessArr[] = calcTable($gainLoseArr, $value);
}

echo (max($totHappinessArr));

?>