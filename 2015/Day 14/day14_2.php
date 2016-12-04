<?php

$myfile = fopen("day14_input.txt", "r") or die("Unable to open file!");

$deerArr = [];
$totTime = 2503;

while(!feof($myfile)) {
	$line = trim(fgets($myfile));

	$lineArr = explode(" ", $line);

	$cycleDist = intval($lineArr[3]) * intval($lineArr[6]);
	$cycleTime = intval($lineArr[6]) + intval($lineArr[13]);

	$deerArr[] = [intval($lineArr[3]), intval($lineArr[6]), intval($lineArr[13]), $cycleDist, $cycleTime, 0, 0];
}

fclose($myfile);

for ($i = 1; $i < $totTime+1; $i++) { 
	$deerDistances = [];

	foreach ($deerArr as $key => $value) {
		$deerCycles = floor($i / $value[4]);

		$deerDist = $value[3] * $deerCycles;
		$deerTime = $value[4] * $deerCycles;

		$timeLeft = $i - $deerTime;

		if ($timeLeft < $value[1]) {
			$deerDist += $timeLeft * $value[0];
		} else {
			$deerDist += $cycleDist;
		}

		$deerArr[$key][5] = $deerDist;
		$deerDistances[$key] = $deerDist;
	}

	$maxDist = max($deerDistances);

	foreach ($deerArr as $key => $value) {
		if ($value[5] == $maxDist) {
			$deerArr[$key][6]++;
		}
	}
}

$pointArr = [];

foreach ($deerArr as $key => $value) {
	$pointArr[] = $value[6];
}

echo(max($pointArr));

?>