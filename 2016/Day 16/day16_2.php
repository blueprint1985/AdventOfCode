<?php

ini_set('memory_limit', '2048M');

$myfile = fopen("day16_input.txt", "r") or die("Unable to open file!");
$ini_state = trim(fgets($myfile));
fclose($myfile);

$disk_size = 35651584;

while (strlen($ini_state) < $disk_size) {
    $a = $ini_state;
    $b = strrev($a);

    $b_arr = str_split($b);

    $b_new = "";
    foreach ($b_arr as $value) {
        $b_new .= ($value === "0") ? "1" : "0";
    }

    $ini_state = $a . "0" . "$b_new";
}

$mid_state = substr($ini_state, 0, $disk_size);

while (strlen($mid_state) % 2 === 0) {
    $state_chunks = str_split($mid_state, 2);
    $mid_state = "";

    foreach ($state_chunks as $chunk) {
        $chunk_arr = str_split($chunk);
        $mid_state .= (array_sum($chunk_arr) % 2 === 0) ? "1" : "0";
    }
}

echo($mid_state);

?>
