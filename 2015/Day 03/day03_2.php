<?php

$santaXPos = 0;
$santaYPos = 0;
$roboXpos = 0;
$roboYpos = 0;

$uniqueHouses = 1;
$visited = [[0,0]];
$counter = 0;

$myfile = fopen("day3_input.txt", "r") or die("Unable to open file!");

while(!feof($myfile)) {
	$direction = fgetc($myfile);
	
	switch ($direction) {
		case '>':
			if ($counter % 2 == 0) $santaXPos++;
			else $roboXpos++;
			break;

		case '<':
			if ($counter % 2 == 0) $santaXPos--;
			else $roboXpos--;
			break;

		case '^':
			if ($counter % 2 == 0) $santaYPos++;
			else $roboYpos++;
			break;

		case 'v':
			if ($counter % 2 == 0) $santaYPos--;
			else $roboYpos--;
			break;
		
		default:
			break;
	}

	if ($counter % 2 == 0) {
		if (!in_array([$santaXPos,$santaYPos], $visited)) {
			$visited[] = [$santaXPos,$santaYPos];
			$uniqueHouses++;
		}
	} else {
		if (!in_array([$roboXpos,$roboYpos], $visited)) {
			$visited[] = [$roboXpos,$roboYpos];
			$uniqueHouses++;
		}
	}

	$counter++;
}

fclose($myfile);

echo($uniqueHouses);

?>