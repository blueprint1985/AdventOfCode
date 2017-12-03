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
$list_len = count($list);

// Loop thouch all elements
while ($i < $list_len - 1) { 
    // Compare the current element with one halfway around
    // If they are the same, add to sum
    if ($list[$i] === $list[($i+($list_len/2))%$list_len]) {
        $sum += intval($list[$i], 10);
    }

    $i++;
}

// Stop timing
$end_time = microtime(true);

// Print results
echo("Result: " . $sum . "\n");
echo("Execution time: " . ($end_time - $start_time) . " seconds");

?>
