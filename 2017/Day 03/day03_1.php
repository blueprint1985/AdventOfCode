<?php

function closestDistToMid($input, $midpoints, $square_size) {
    $distance = $square_size;

    foreach ($midpoints as $value) {
        $distance = min($distance, abs($input - $value));
    }

    return $distance;
}

$myfile = fopen("day03_input.txt", "r") or die("Unable to open file!");
$input = trim(fgets($myfile));
fclose($myfile);

$start_time = microtime(true);

$input = intval($input);

$square_size = ceil(sqrt($input));
$square_size = ($square_size % 2 === 0) ? $square_size + 1 : $square_size;
$square_max = $square_size ** 2;

$square_mid_low = $square_max - (floor($square_size / 2));
$square_mid_left = $square_mid_low - ($square_size - 1);
$square_mid_top = $square_mid_left - ($square_size - 1);
$square_mid_right = $square_mid_top - ($square_size - 1);

$midpoints = array($square_mid_low, $square_mid_left, $square_mid_top, $square_mid_right);
$midpoint_dist = closestDistToMid($input, $midpoints, $square_size);
$manhattan_dist = $midpoint_dist + (floor($square_size / 2));

$end_time = microtime(true);

echo("Result: " . $manhattan_dist . "\n");
echo("Execution time: " . ($end_time - $start_time) . " seconds");

?>
