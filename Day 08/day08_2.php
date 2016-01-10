<?php

$total = 0;

$myfile = fopen("day8_input.txt", "r") or die("Unable to open file!");

while(!feof($myfile)) {
	$line = addslashes(trim(fgets($myfile)));

	eval("\$val = \"".$line."\";");

	$countStr = strlen(implode("", array("\"", $line, "\"")));
    $countEsc = strlen($val);

	$total += $countStr - $countEsc;

}

fclose($myfile);

echo($total);

?>