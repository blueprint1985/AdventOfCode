<?php

function sizes($i, $left, $count, $containers, &$combinations, &$buckets) {
	if($left == 0) {
		$combinations++;
		$buckets[$count]++;
	}

	if(!isset($containers[$i]) || $left < $containers[$i]) return;

	sizes($i+1, $left - $containers[$i], $count+1, $containers, $combinations, $buckets);
	sizes($i+1, $left, $count, $containers, $combinations, $buckets);
}



$containers  = [];

$myfile = fopen("day17_input.txt", "r") or die("Unable to open file!");

while(!feof($myfile)) {
	$line = trim(fgets($myfile));

	$containers[] = intval($line);
}

fclose($myfile);

sort($containers);

sizes(0, 150, 0, $containers, $combinations, $buckets);

echo ($buckets[min(array_keys($buckets))]);

?>