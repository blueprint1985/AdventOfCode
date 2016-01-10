<?php

$myfile = fopen("day25_input.txt", "r") or die("Unable to open file!");

$line = trim(fgets($myfile));
$lineArr = explode(" ", $line);
$targetX = trim($lineArr[count($lineArr)-1], "\.");
$targetY = trim($lineArr[count($lineArr)-3], ",");

fclose($myfile);

$countX = 1;
$countY = 1;
$nextY = 2;
$currVal = 20151125;

while (true) {
	$currVal = bcmod(bcmul($currVal, 252533), 33554393);

	if ($countY == 1) {
		$countX = 1;
		$countY = $nextY;
		$nextY++;
	} else {
		$countX++;
		$countY--;
	}

	if ($countX == $targetX && $countY == $targetY) break;
}

echo $currVal;

?>