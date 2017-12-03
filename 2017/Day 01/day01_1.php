<?php

// READ INPUT

$myfile = fopen("day01_input.txt", "r") or die("Unable to open file!");
$captcha = trim(fgets($myfile));
fclose($myfile);

// END READ INPUT

// Start timing
$start_time = microtime(true);

// Initiate variables
$sum = 0;
$list = str_split($captcha);
$i = 0;
$list_len_short = count($list) - 1;

// Loop thouch all elements except the last one
while ($i < $list_len_short) { 
    // Compare the current element with next
    // If they are the same, add to sum
    if ($list[$i] === $list[$i+1]) {
        $sum += intval($list[$i], 10);
    }

    $i++;
}

// Compare the last element with the first
// If they are the same, add to sum
if ($list[$i] === $list[0]) {
    $sum += intval($list[$i], 10);
}

// Stop timing
$end_time = microtime(true);

// Print results
echo("Result: " . $sum . "\n");
echo("Execution time: " . ($end_time - $start_time) . " seconds");

?>
