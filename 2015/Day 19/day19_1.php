<?php

function buildMolecules($keys, $replacements, $molecule) {
	$possMolecules = [];

	foreach ($molecule as $key => $value) {
		if (in_array($value, $keys)) {
			foreach ($replacements[$value] as $key2 => $value2) {
				$newMolecule = $molecule;
				$newMolecule[$key] = $value2;
				if (!in_array(implode($newMolecule), $possMolecules)) $possMolecules[] = implode($newMolecule);
			}
		}

		if ($key < count($molecule)-1) {
			if (in_array($value.$molecule[$key+1], $keys)) {
				foreach ($replacements[$value.$molecule[$key+1]] as $key2 => $value2) {
					$newMolecule = $molecule;
					$newMolecule[$key] = $value2;
					unset($newMolecule[$key+1]);
					if (!in_array(implode($newMolecule), $possMolecules)) $possMolecules[] = implode($newMolecule);
				}
			}
		}
	}

	return $possMolecules;
}

$keys = [];
$replacements = [];

$myfile = fopen("day19_input.txt", "r") or die("Unable to open file!");

while(!feof($myfile)) {
	$line = trim(fgets($myfile));

	if ($line != "") {
		$lineArr = explode(" ", $line);

		if (count($lineArr) != 3) {
			$startMol = str_split($lineArr[0]);
		} else {
			if (!in_array($lineArr[0], $keys)) $keys[] = $lineArr[0];
			$replacements[$lineArr[0]][] = $lineArr[2];
		}
	}
}

fclose($myfile);

echo count(buildMolecules($keys, $replacements, $startMol));

?>