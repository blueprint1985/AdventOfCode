<?php

$niceStr = 0;

$rowArr1 = [];
$rowArr2 = [];
$rowCount = 1;

$myfile = fopen("day5_input.txt", "r") or die("Unable to open file!");

while(!feof($myfile)) {
	$line = trim(fgets($myfile));

	$matchPair = preg_match('/([a-z][a-z])[a-z]*\1/', $line);
	$matchRepeat = preg_match('/([a-z])[a-z]\1/', $line);

	if ($matchPair && $matchRepeat) {
		$niceStr++;
	}
}

fclose($myfile);

echo($niceStr);

?>