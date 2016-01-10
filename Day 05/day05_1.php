<?php

$niceStr = 0;

$myfile = fopen("day5_input.txt", "r") or die("Unable to open file!");

while(!feof($myfile)) {
	$line = trim(fgets($myfile));

	$numOfWovels = preg_match_all('/[aeiou]/', $line);
	$badPairs = preg_match('/ab|cd|pq|xy/', $line);
	$goodPair = preg_match('/([a-z])\1/', $line);

	if ($numOfWovels > 2 && !$badPairs && $goodPair) {
		$niceStr++;
	}
}

fclose($myfile);

echo($niceStr);

?>