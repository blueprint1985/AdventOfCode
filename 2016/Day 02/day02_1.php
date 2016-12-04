<?php

$myfile = fopen("day02_input.txt", "r") or die("Unable to open file!");
$instr_arr = array();

while(!feof($myfile)) {
    $instr_arr[] = trim(fgets($myfile));
}

fclose($myfile);

$keypad = array(array(1, 2, 3), array(4, 5, 6), array(7, 8, 9));
$current = array("x" => 1, "y" => 1);
$keycode = "";

foreach ($instr_arr as $value) {
    $instructions = str_split($value);

    foreach ($instructions as $instruction) {
        switch ($instruction) {
            case 'U':
                if (($current['y'] - 1) >= 0) {
                    $current['y']--;
                }
                break;

            case 'R':
                if (($current['x'] + 1) <= 2) {
                    $current['x']++;
                }
                break;

            case 'D':
                if (($current['y'] + 1) <= 2) {
                    $current['y']++;
                }
                break;

            case 'L':
                if (($current['x'] - 1) >= 0) {
                    $current['x']--;
                }
                break;

            default:
                break;
        }
    }

    $keycode .= $keypad[$current['y']][$current['x']];
}

echo($keycode);

?>
