<?php

function battle($playerStats, $bossStats) {
	$playerHit = $playerStats[1] - $bossStats[2];
	$bossHit = $bossStats[1] - $playerStats[2];

	if ($playerHit < 1) $playerHit = 1;
	if ($bossHit < 1) $bossHit = 1;

	
	$bossNewHP = $bossStats[0] - $playerHit;

	if ($bossNewHP <= 0) {
		return true;
	} else {
		$playerNewHP = $playerStats[0] - $bossHit;

		if ($playerNewHP <= 0) {
			return false;
		} else {
			$playerNewStats = [$playerNewHP, $playerStats[1], $playerStats[2]];
			$bossNewStats = [$bossNewHP, $bossStats[1], $bossStats[2]];

			return battle($playerNewStats, $bossNewStats);
		}
	}
}

function buildCombos($weapons, $armor, $rings) {
	$combos = [];

	foreach ($weapons as $key1 => $value1) {
		$combos[] = [$value1[0], $value1[1], $value1[2]];

		foreach ($armor as $key2 => $value2) {
			$combos[] = [$value1[0]+$value2[0], $value1[1]+$value2[1], $value1[2]+$value2[2]];

			foreach ($rings as $key3 => $value3) {
				$combos[] = [$value1[0]+$value3[0], $value1[1]+$value3[1], $value1[2]+$value3[2]];
				$combos[] = [$value1[0]+$value2[0]+$value3[0], $value1[1]+$value2[1]+$value3[1], $value1[2]+$value2[2]+$value3[2]];

				foreach ($rings as $key4 => $value4) {
					if ($key4 != $key3) {
						$combos[] = [$value1[0]+$value3[0]+$value4[0], $value1[1]+$value3[1]+$value4[1], $value1[2]+$value3[2]+$value4[2]];
						$combos[] = [$value1[0]+$value2[0]+$value3[0]+$value4[0], $value1[1]+$value2[1]+$value3[1]+$value4[1], $value1[2]+$value2[2]+$value3[2]+$value4[2]];
					}
				}
			}
		}
	}

	return $combos;
}

$myfile = fopen("day21_input.txt", "r") or die("Unable to open file!");

$bossStats = [];

while(!feof($myfile)) {
	$line = trim(fgets($myfile));
	$lineArr = explode(": ", $line);
	$bossStats[] = intval($lineArr[1]);
}

fclose($myfile);

$weapons = [[8,4,0], [10,5,0], [25,6,0], [40,7,0], [74,8,0]];
$armor = [[13,0,1], [31,0,2], [53,0,3], [75,0,4], [102,0,5]];
$rings = [[25,1,0], [50,2,0], [100,3,0], [20,0,1], [40,0,2], [80,0,3]];

$allCombos = buildCombos($weapons, $armor, $rings);

$winnerCosts = [];

foreach ($allCombos as $key => $value) {
	$playerStats = [100, $value[1], $value[2]];

	$thisWinner = battle($playerStats, $bossStats);

	if ($thisWinner) {
		$winnerCosts[] = intval($value[0]);
	}
}

echo (min($winnerCosts));

?>