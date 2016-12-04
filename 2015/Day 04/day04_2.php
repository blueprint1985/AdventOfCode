<?php

$myfile = fopen("day4_input.txt", "r") or die("Unable to open file!");

$secretKey = trim(fgets($myfile));

fclose($myfile);

$answer = 1;

while(true) {
	$hashedCode = md5($secretKey.$answer);

	if (substr($hashedCode, 0, 6) === "000000") {
		break;
	}

	$answer++;
}

echo($answer."\n".$exec_time." seconds");

?>