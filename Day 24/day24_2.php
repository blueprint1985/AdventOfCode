<?php

function isZero($var) {
	return ($var === 0);
}

function calcSmallest($packets, $weight) {
	$checkStr = implode(array_fill(0, count($packets), 1));
	$checkDec = bindec($checkStr);

	for ($i = 0; $i <= $checkDec; $i++) {
		$binStr = decbin($i);
		if (isset($smallest) && substr_count($binStr, "1") > $smallest[0]) continue;
		$binStrArr = str_split(str_pad($binStr, count($packets), "0", STR_PAD_LEFT));
		$new_vals = [];

		foreach ($binStrArr as $key => $value) {
			$new_vals[] = $value * $packets[$key];
		}

		$new_vals = array_filter($new_vals);

		if (array_sum($new_vals) == $weight) {
			$newLen = count($new_vals);
			$newQuan = array_product($new_vals);

			if (isset($smallest)) {
				if ($newLen <= $smallest[0] && $newQuan < $smallest[1]) $smallest = [$newLen, $newQuan];
			} else {
				$smallest = [$newLen, $newQuan];
			}
		}
	}

	return $smallest[1];
}

$myfile = fopen("day24_input.txt", "r") or die("Unable to open file!");
$packets = [];

while(!feof($myfile)) {
	$line = trim(fgets($myfile));

	$packets[] = $line;
}

fclose($myfile);
$weight = array_sum($packets) / 4;
echo (calcSmallest($packets, $weight));

?>