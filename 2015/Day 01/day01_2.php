<?php

$counter = 0;
$position = 0;

$myfile = fopen("day1_input.txt", "r") or die("Unable to open file!");

while(!feof($myfile)) {
	$character = fgetc($myfile);
	$position++;

	if ($character == '(') {
		$counter++;
	} else if ($character == ')') {
		$counter--;
	} else {
		$counter = $counter;
	}

	if ($counter == -1) {
		break;
	}
}

fclose($myfile);

echo($position);

?>