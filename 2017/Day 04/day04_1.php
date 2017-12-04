<?php

// READ INPUT

$myfile = fopen("day04_input.txt", "r") or die("Unable to open file!");
$passwords_arr = [];

while(!feof($myfile)) {
    $passwords_arr[] = trim(fgets($myfile));
}

fclose($myfile);

// END READ INPUT

// Start timing
$start_time = microtime(true);

// Initiate checksum
$correct = 0;

// Loop though each password
foreach ($passwords_arr as $pass) {
    // Convert the password to array and check for duplicates by flipping array
    // and since an array must have unique keys, if there are any duplicates,
    // the flipped array will be shorter
    $pass_split = explode(" ", $pass);
    if (count($pass_split) === count(array_flip($pass_split))) {
        $correct++;
    }
}

// Stop timing
$end_time = microtime(true);

// Print results
echo("Result: " . $correct . "\n");
echo("Execution time: " . ($end_time - $start_time) . " seconds");

?>
