<?php

function switchLights($inputArr) {
	$outputArr = [[]];

	foreach ($inputArr as $key => $value) {
		foreach ($value as $key2 => $value2) {

			$valArr = [];
			$maxX = count($value)-1;
			$maxY = count($inputArr)-1;

			if ($key == 0 && $key2 == 0) {
				$outputArr[$key][$key2] = "#";
				continue;
			} elseif ($key == 0 && $key2 == $maxX) {
				$outputArr[$key][$key2] = "#";
				continue;
			} elseif ($key == $maxY && $key2 == $maxX) {
				$outputArr[$key][$key2] = "#";
				continue;
			} elseif ($key == $maxY && $key2 == 0) {
				$outputArr[$key][$key2] = "#";
				continue;
			} elseif ($key == 0 && $key2 != 0 && $key2 != $maxX) {
				$val1 = $inputArr[$key][$key2+1];
				$val2 = $inputArr[$key+1][$key2+1];
				$val3 = $inputArr[$key+1][$key2];
				$val4 = $inputArr[$key+1][$key2-1];
				$val5 = $inputArr[$key][$key2-1];

				$valArr = [$val1, $val2, $val3, $val4, $val5];
			} elseif ($key != 0 && $key != $maxY && $key2 == $maxX) {
				$val1 = $inputArr[$key+1][$key2];
				$val2 = $inputArr[$key+1][$key2-1];
				$val3 = $inputArr[$key][$key2-1];
				$val4 = $inputArr[$key-1][$key2-1];
				$val5 = $inputArr[$key-1][$key2];

				$valArr = [$val1, $val2, $val3, $val4, $val5];
			} elseif ($key == $maxY && $key2 != 0 && $key2 != $maxX) {
				$val1 = $inputArr[$key][$key2-1];
				$val2 = $inputArr[$key-1][$key2-1];
				$val3 = $inputArr[$key-1][$key2];
				$val4 = $inputArr[$key-1][$key2+1];
				$val5 = $inputArr[$key][$key2+1];

				$valArr = [$val1, $val2, $val3, $val4, $val5];
			} elseif ($key != 0 && $key != $maxY && $key2 == 0) {
				$val1 = $inputArr[$key-1][$key2];
				$val2 = $inputArr[$key-1][$key2+1];
				$val3 = $inputArr[$key][$key2+1];
				$val4 = $inputArr[$key+1][$key2+1];
				$val5 = $inputArr[$key+1][$key2];

				$valArr = [$val1, $val2, $val3, $val4, $val5];
			} else {
				$val1 = $inputArr[$key-1][$key2-1];
				$val2 = $inputArr[$key-1][$key2];
				$val3 = $inputArr[$key-1][$key2+1];
				$val4 = $inputArr[$key][$key2+1];
				$val5 = $inputArr[$key+1][$key2+1];
				$val6 = $inputArr[$key+1][$key2];
				$val7 = $inputArr[$key+1][$key2-1];
				$val8 = $inputArr[$key][$key2-1];

				$valArr = [$val1, $val2, $val3, $val4, $val5, $val6, $val7, $val8];
			}

			$occurArr = array_count_values($valArr);

			$numHashtags = (isset($occurArr["#"])) ? $occurArr["#"] : 0;

			if ($value2 == "#") {
				if ($numHashtags == 2 || $numHashtags == 3) {
					$outputArr[$key][$key2] = "#";
				} else {
					$outputArr[$key][$key2] = ".";
				}
			} else {
				if ($numHashtags == 3) {
					$outputArr[$key][$key2] = "#";
				} else {
					$outputArr[$key][$key2] = ".";
				}
			}
		}
	}

	return $outputArr;
}

function countHashtags($inputArr) {
	$numHashtags = 0;

	foreach ($inputArr as $key => $value) {
		$occurArr = array_count_values($value);

		$numHashtags += (isset($occurArr["#"])) ? $occurArr["#"] : 0;
	}

	return $numHashtags;
}

$grid = [];

$myfile = fopen("day18_input.txt", "r") or die("Unable to open file!");

while(!feof($myfile)) {
	$line = trim(fgets($myfile));

	$lineArr = str_split($line);

	$grid[] = $lineArr;
}

fclose($myfile);

$maxX = count($grid[0])-1;
$maxY = count($grid)-1;

$grid[0][0] = "#";
$grid[0][$maxX] = "#";
$grid[$maxY][$maxX] = "#";
$grid[$maxY][0] = "#";

for ($i = 0; $i < 100; $i++) { 
	$grid = switchLights($grid);
}

echo (countHashtags($grid));

?>