<?php

$gridArr = array_fill(0, 1000, array_fill(0, 1000, false));

$numOfLit = 0;

$myfile = fopen("day6_input.txt", "r") or die("Unable to open file!");

while(!feof($myfile)) {
	$line = trim(fgets($myfile));

	$lineArr = explode(" ", $line);

	if (count($lineArr) == 4) {
		$thisCommand = $lineArr[0];
		$startArr = explode(",", $lineArr[1]);
		$endArr = explode(",", $lineArr[3]);
	} else {
		$thisCommand = $lineArr[0].$lineArr[1];
		$startArr = explode(",", $lineArr[2]);
		$endArr = explode(",", $lineArr[4]);
	}

	$startX = $startArr[0];
	$startY = $startArr[1];
	$endX = $endArr[0];
	$endY = $endArr[1];

	for ($i = $startX; $i < $endX+1; $i++) { 
		for ($j = $startY; $j < $endY+1; $j++) {
			if ($thisCommand == "turnon") {
				if (!$gridArr[$i][$j]) $numOfLit++;

				$gridArr[$i][$j] = true;
			} elseif ($thisCommand == "turnoff") {
				if ($gridArr[$i][$j]) $numOfLit--;

				$gridArr[$i][$j] = false;
			} else {
				if ($gridArr[$i][$j]) $numOfLit--;
				else $numOfLit++;

				$gridArr[$i][$j] = !$gridArr[$i][$j];
			}
		}
	}
}

fclose($myfile);

echo($numOfLit);

?>