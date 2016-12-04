<?php

$ingArr = [];

$myfile = fopen("day15_input.txt", "r") or die("Unable to open file!");

while(!feof($myfile)) {
	$line = trim(fgets($myfile));

	$lineArr = explode(" ", $line);

	$ingArr[] = ["cap" => trim($lineArr[2], ","), "dur" => trim($lineArr[4], ","), "fla" => trim($lineArr[6], ","), "tex" => trim($lineArr[8], ","), "cal" => trim($lineArr[10], ",")];
}

fclose($myfile);

$scoreArr = [];

for ($i = 0; $i <= 100; $i++) {
	for ($j = 0; $j <= 100-$i; $j++) {
		for ($k = 0; $k <= 100-$i-$j; $k++) {
			$l = 100-$i-$j-$k;

			$cap = $ingArr[0]["cap"] * $i + $ingArr[1]["cap"] * $j + $ingArr[2]["cap"] * $k + $ingArr[3]["cap"] * $l;
			$dur = $ingArr[0]["dur"] * $i + $ingArr[1]["dur"] * $j + $ingArr[2]["dur"] * $k + $ingArr[3]["dur"] * $l;
			$fla = $ingArr[0]["fla"] * $i + $ingArr[1]["fla"] * $j + $ingArr[2]["fla"] * $k + $ingArr[3]["fla"] * $l;
			$tex = $ingArr[0]["tex"] * $i + $ingArr[1]["tex"] * $j + $ingArr[2]["tex"] * $k + $ingArr[3]["tex"] * $l;

			if ($cap < 0) $cap = 0;
			if ($dur < 0) $dur = 0;
			if ($fla < 0) $fla = 0;
			if ($tex < 0) $tex = 0;

    		$scoreArr[] = $cap * $dur* $fla * $tex;
		}
	}
}

echo (max($scoreArr));

?>