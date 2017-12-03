<?php

$myfile = fopen("day02_input.txt", "r") or die("Unable to open file!");
$instr_arr = array();

$spreadsheet_arr = [];

while(!feof($myfile)) {
    $spreadsheet_arr[] = trim(fgets($myfile));
}

fclose($myfile);

$start_time = microtime(true);

$checksum = 0;

foreach ($spreadsheet_arr as $row) {
    $clean_row = array_filter(explode(" ", $row));
    $checksum += (max($clean_row) - min($clean_row));
}

$end_time = microtime(true);

echo("Result: " . $checksum . "\n");
echo("Execution time: " . ($end_time - $start_time) . " seconds");

echo($checksum);

?>
