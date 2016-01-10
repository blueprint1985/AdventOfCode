<?php

$counter = 0;

$myfile = fopen("day1_input.txt", "r") or die("Unable to open file!");

while(!feof($myfile)) {
	$character = fgetc($myfile);

	if ($character == '(') {
		$counter++;
	} else if ($character == ')') {
		$counter--;
	} else {
		$counter = $counter;
	}
}

fclose($myfile);

echo($counter);

?>