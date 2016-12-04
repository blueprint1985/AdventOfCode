<?php

$xPos = 0;
$yPos = 0;

$uniqueHouses = 1;
$visited = [[0,0]];

$myfile = fopen("day3_input.txt", "r") or die("Unable to open file!");

while(!feof($myfile)) {
	$direction = fgetc($myfile);
	
	switch ($direction) {
		case '>':
			$xPos++;
			break;

		case '<':
			$xPos--;
			break;

		case '^':
			$yPos++;
			break;

		case 'v':
			$yPos--;
			break;
		
		default:
			break;
	}

	if (!in_array([$xPos,$yPos], $visited)) {
		$visited[] = [$xPos,$yPos];
		$uniqueHouses++;
	}
}

fclose($myfile);

echo($uniqueHouses);

?>