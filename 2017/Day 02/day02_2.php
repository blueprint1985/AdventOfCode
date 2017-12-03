<?php

// READ INPUT

$myfile = fopen("day02_input.txt", "r") or die("Unable to open file!");
$spreadsheet_arr = array();

while(!feof($myfile)) {
    $spreadsheet_arr[] = trim(fgets($myfile));
}

fclose($myfile);

// END READ INPUT

// Start timing
$start_time = microtime(true);

// Initiate result
$result = 0;

// Loop though each row in the spreadsheet
foreach ($spreadsheet_arr as $row) {
    // Convert the row to array and calculate checksum for the row
    // Also get array_values since we need index to be reset
    // Get length of row
    $clean_row = array_values(array_filter(explode(" ", $row)));
    $length = count($clean_row);

    // Outer loop loops entire row except last element
    // Inner loop loops all elements after outer row current index
    for ($i = 0; $i < $length - 1; $i++) {
        for ($j = $i + 1; $j < $length; $j++) {
            // Put current elements into array for easier comparint
            $values = array($clean_row[$i], $clean_row[$j]);

            // Compare values
            // If divisible, add division to result
            if (max($values) % min($values) === 0) {
                $result += max($values) / min($values);
            }
        }
    }
}

// Stop timing
$end_time = microtime(true);

// Print results
echo("Result: " . $result . "\n");
echo("Execution time: " . ($end_time - $start_time) . " seconds");

?>
