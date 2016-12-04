<?php

$myfile = fopen("day02_input.txt", "r") or die("Unable to open file!");
$instr_arr = array();

while(!feof($myfile)) {
    $instr_arr[] = trim(fgets($myfile));
}

fclose($myfile);

$keypad = array(
    array(" ", " ", "1", " ", " "),
    array(" ", "2", "3", "4", " "),
    array("5", "6", "7", "8", "9"),
    array(" ", "A", "B", "C", " "),
    array(" ", " ", "C", " ", " "));

$is_buttons = array("2-0", "1-1", "2-1", "3-1", "0-2", "1-2", "2-2", "3-2", "4-2", "1-3", "2-3", "3-3", "2-4");

$current = array("x" => 0, "y" => 2);
$keycode = "";

foreach ($instr_arr as $value) {
    $instructions = str_split($value);

    foreach ($instructions as $instruction) {
        switch ($instruction) {
            case 'U':
                $next_pos = strval($current['x']) . "-" . (strval($current['y']) - 1);

                if (in_array($next_pos, $is_buttons)) {
                    $current['y']--;
                }
                break;

            case 'R':
                $next_pos = (strval($current['x']) + 1) . "-" . strval($current['y']);

                if (in_array($next_pos, $is_buttons)) {
                    $current['x']++;
                }
                break;

            case 'D':
                $next_pos = strval($current['x']) . "-" . (strval($current['y']) + 1);

                if (in_array($next_pos, $is_buttons)) {
                    $current['y']++;
                }
                break;

            case 'L':
                $next_pos = (strval($current['x']) - 1) . "-" . strval($current['y']);

                if (in_array($next_pos, $is_buttons)) {
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
