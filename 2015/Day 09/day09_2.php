<?php

// Not my function, fount it at http://www.needcodefor.com/php/php-function-to-generate-all-permutations/
function permutations($set) { 
	$solutions = array();
	$n = count($set);
	$p = array_keys($set);
	$i = 1;
 
	while ($i<$n) {
		if ($p[$i]>0) {
			$p[$i]--;
			$j=0;
			if ($i%2==1) $j=$p[$i];
			//swap
			$tmp=$set[$j];
			$set[$j]=$set[$i];
			$set[$i]=$tmp;
			$i=1;
			$solutions[]=$set;
		} elseif ($p[$i]==0) {
			$p[$i]=$i;
			$i++;
		}
	}

	return $solutions;
}

// Rest of code is mine

function calcShortest($perms, $distances) {
	$totDistances = [];
		
	foreach ($perms as $thisPerm) {
		$thisDistance = 0;

		for ($i = 0; $i < count($thisPerm)-1; $i++) {
			$currCity = $thisPerm[$i];
			$nextCity = $thisPerm[$i+1];

			foreach ($distances as $key => $value) {
				if (in_array($currCity, $value) && in_array($nextCity, $value)) {
					$thisDistance += $value[2];
					break;
				}
			}
		}

		$totDistances[] = $thisDistance;
	}

	return max($totDistances);
}

$cities = [];
$distances = [];

$myfile = fopen("day9_input.txt", "r") or die("Unable to open file!");

while(!feof($myfile)) {
	$line = trim(fgets($myfile));

	$lineArr = explode(" ", $line);

	if (!in_array($lineArr[0], $cities)) $cities[] = $lineArr[0];
	if (!in_array($lineArr[2], $cities)) $cities[] = $lineArr[2];
	$distances[] = [$lineArr[0], $lineArr[2], $lineArr[4]];
}

fclose($myfile);

$permArr = permutations(array_values($cities));
if (!in_array($cities, $permArr)) $permArr[] = $cities;

echo calcShortest($permArr, $distances);

?>