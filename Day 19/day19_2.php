<?php

//First function is not mine;
//http://stackoverflow.com/questions/19907155/how-to-replace-a-nth-occurrence-in-a-string

function str_replace_nth($search, $replace, $subject, $nth) {
    $found = preg_match_all('/'.preg_quote($search).'/', $subject, $matches, PREG_OFFSET_CAPTURE);
    if (false !== $found && $found > $nth) {
        return substr_replace($subject, $replace, $matches[0][$nth][1], strlen($search));
    }
    return $subject;
}

function getKeyFromValue($replacements, $myKey) {
	foreach ($replacements as $key => $value) {
		if (in_array($myKey, $value)) return $key;
	}
}

function replaceValWithKey($str, $values, $replacements) {
	$newStr = [];

	foreach ($values as $key => $value) {
		$numOcc = substr_count($str, $value);
		$thisKey = getKeyFromValue($replacements, $value);

		for ($i = 0; $i < $numOcc; $i++) { 
			$newStr[] = str_replace_nth($value, $thisKey, $str, $i);
		}
	}

	return $newStr;
}

function searchMolecule($values, $replacements, $molArray, $endMol) {
	$newMols = [];

	foreach ($molArray as $key => $value) {
		$getMols = replaceValWithKey($value, $values, $replacements);
		$newMols = array_merge($newMols, $getMols);
	}

	$newMols = array_unique($newMols, SORT_STRING);
	$newMols = array_diff($newMols, $molArray);

	return $newMols;
}


$keys = [];
$replacements = [];
$values = [];

$myfile = fopen("day19_input.txt", "r") or die("Unable to open file!");

while(!feof($myfile)) {
	$line = trim(fgets($myfile));

	if ($line != "") {
		$lineArr = explode(" ", $line);

		if (count($lineArr) != 3) {
			$startMol = [$lineArr[0]];
		} else {
			if (!in_array($lineArr[0], $keys)) $keys[] = $lineArr[0];
			$values[] = $lineArr[2];
			$replacements[$lineArr[0]][] = $lineArr[2];
		}
	}
}

fclose($myfile);

$i = 0;

while (!in_array("e", $startMol)) {
	$startMol = searchMolecule($values, $replacements, [$startMol[0]], "e");
	$i++;
}

echo $i;

?>