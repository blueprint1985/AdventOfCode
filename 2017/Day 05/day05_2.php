<?php

// READ INPUT

$myfile = fopen("day05_input.txt", "r") or die("Unable to open file!");
$instr_arr = [];

while(!feof($myfile)) {
    $instr_arr[] = trim(fgets($myfile));
}

fclose($myfile);

// END READ INPUT

// Start timing
$start_time = microtime(true);

// Make integers of all values
$instr_arr = array_map('intval', $instr_arr);

// Initiate variables
$pos = 0;
$max_pos = count($instr_arr) - 1;
$i = 0;

// Loop though each password
while ($pos <= $max_pos) {
    // Move position by the value of the current position
    $old_pos = $pos;
    $pos += $instr_arr[$pos];

    // Increase or decrease last position's value
    $instr_arr[$old_pos] = ($instr_arr[$old_pos] >= 3) ? $instr_arr[$old_pos] - 1 : $instr_arr[$old_pos] + 1;

    $i++;
}

// Stop timing
$end_time = microtime(true);

// Print results
echo("Result: " . $i . "\n");
echo("Execution time: " . ($end_time - $start_time) . " seconds");

?>
