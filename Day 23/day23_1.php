<?php


$myfile = fopen("day23_input.txt", "r") or die("Unable to open file!");

$instructions = [];

while(!feof($myfile)) {
	$line = trim(fgets($myfile));
	$lineArr = explode(" ", $line);
	$lineArr[1] = trim($lineArr[1], ",");

	$instructions[] = $lineArr;
}

fclose($myfile);

$regCounter = 0;
$regMax = count($instructions);
$a = 0;
$b = 0;

while(true) {
	if ($regCounter < 0 || $regCounter >= $regMax) break;

	$currInstruct = $instructions[$regCounter];

	switch ($currInstruct[0]) {
		case 'hlf':
			$regCounter++;
			if ($currInstruct[1] == "a") $a = $a/2;
			elseif ($currInstruct[1] == "b") $b = $b/2;
			break;
		
		case 'tpl':
			$regCounter++;
			if ($currInstruct[1] == "a") $a = $a*3;
			elseif ($currInstruct[1] == "b") $b = $b*3;
			break;

		case 'inc':
			$regCounter++;
			if ($currInstruct[1] == "a") $a++;
			elseif ($currInstruct[1] == "b") $b++;
			break;

		case 'jmp':
			$direction = intval($currInstruct[1]);

			$regCounter = $regCounter += $direction;
			break;

		case 'jie':
			$direction = intval($currInstruct[2]);

			if ($currInstruct[1] == "a" && $a % 2 == 0) {
				$regCounter += $direction;
			} elseif ($currInstruct[1] == "b" && $b % 2 == 0) {
				$regCounter += $direction;
			} else {
				$regCounter++;
			}
			break;

		case 'jio':
			$direction = intval($currInstruct[2]);

			if ($currInstruct[1] == "a" && $a == 1) {
				$regCounter += $direction;
			} elseif ($currInstruct[1] == "b" && $b == 1) {
				$regCounter += $direction;
			} else {
				$regCounter++;
			}
			break;

		default:
			break;
	}
}

echo $b;

?>