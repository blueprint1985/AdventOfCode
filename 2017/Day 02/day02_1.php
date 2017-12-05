<?php

// READ INPUT

$myfile = fopen("day02_input.txt", "r") or die("Unable to open file!");
$spreadsheet_arr = [];

while(!feof($myfile)) {
    $spreadsheet_arr[] = trim(fgets($myfile));
}

fclose($myfile);

// END READ INPUT

// Start timing
$start_time = microtime(true);

// Initiate checksum
$checksum = 0;

// Loop though each row in the spreadsheet
foreach ($spreadsheet_arr as $row) {
    // Convert the row to array and calculate checksum for the row
    // Add to total checksum
    $clean_row = array_filter(explode(" ", $row));
    $checksum += (max($clean_row) - min($clean_row));
}

// Stop timing
$end_time = microtime(true);

// Print results
echo("Result: " . $checksum . "\n");
echo("Execution time: " . ($end_time - $start_time) . " seconds");

?>
