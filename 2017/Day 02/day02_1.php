<?php

$myfile = fopen("day02_input.txt", "r") or die("Unable to open file!");
$instr_arr = array();

$spreadsheet_arr = [];

while(!feof($myfile)) {
    $spreadsheet_arr[] = trim(fgets($myfile));
}

fclose($myfile);

$checksum = 0;

foreach ($spreadsheet_arr as $row) {
    $clean_row = array_filter(explode(" ", $row));
    $row_high = 0;
    $row_low = PHP_INT_MAX;

    foreach ($clean_row as $value) {
        $row_high = ($value > $row_high) ? $value : $row_high;
        $row_low = ($value < $row_low) ? $value : $row_low;
    }

    $checksum += ($row_high - $row_low);
}


echo($checksum);

?>
