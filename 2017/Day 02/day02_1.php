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
    $checksum += (max($clean_row) - min($clean_row));
}


echo($checksum);

?>
