<?php

$myfile = fopen("day14_input.txt", "r") or die("Unable to open file!");

$deerDistances = [];
$totTime = 2503;

while(!feof($myfile)) {
	$line = trim(fgets($myfile));

	$lineArr = explode(" ", $line);

	$cycleDist = intval($lineArr[3]) * intval($lineArr[6]);
	$cycleTime = intval($lineArr[6]) + intval($lineArr[13]);

	$deerCycles = floor($totTime / $cycleTime);

	$deerDist = $cycleDist * $deerCycles;
	$deerTime = $cycleTime * $deerCycles;

	$timeLeft = $totTime - $deerTime;

	if ($timeLeft < intval($lineArr[6])) {
		$deerDist += $timeLeft * intval($lineArr[3]);
	} else {
		$deerDist += $cycleDist;
	}

	$deerDistances[] = $deerDist;
}

fclose($myfile);

echo(max($deerDistances));

?>