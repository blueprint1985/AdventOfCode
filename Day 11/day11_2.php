<?php

$myfile = fopen("day11_input.txt", "r") or die("Unable to open file!");

$line = "hxbxxzaa";

fclose($myfile);

$triadArr = ["abc", "bcd", "cde", "def", "efg", "fgh", "pqr", "qrs", "rst", "stu", "tuv", "uvw", "vwx", "wxy", "xyz"]; 

while (true) {
	//echo($line."\n");

	$hasTriad = false;

	foreach ($triadArr as $value) {
		if (strpos($line,$value) !== false) {
			$hasTriad = true;
			break;
		}
	}

	$hasPair = preg_match('/[a-z]*([a-z])\1[a-z]*([a-z])\2[a-z]*/', $line);
	$hasIOL =  preg_match('/([iol])/', $line);

	if ($hasTriad && $hasPair && !$hasIOL) {
		break;
	} else {
		$line++;
	}
}

echo($line);

?>