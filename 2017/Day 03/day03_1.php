<?php

// READ INPUT

$myfile = fopen("day03_input.txt", "r") or die("Unable to open file!");
$input = trim(fgets($myfile));
fclose($myfile);

// END READ INPUT

// Start timing
$start_time = microtime(true);

// Convert input to int
$input = intval($input);

// Algoritm to calculate the width and height of the square that has the input
// in the edge of the suqare. Since this type of square can only have an odd 
// number as the length of the side, we need to add 1 to the size if the result
// is even. We also need to know the maximum number for the calculated square
// size.
$square_size = ceil(sqrt($input));
$square_size = ($square_size % 2 === 0) ? $square_size + 1 : $square_size;
$square_max = $square_size ** 2;

// We now need to calculate the midpoints of each side. We do this, since the
// midpoints have a straight path to square 1. We know that the maximum number
// possible will always be in the lower right corner and numbers lower
// clockwise around the edge. Mid bottom is halfway to the next corner, which
// means half the square_size away from maximum, and then the midpoints are
// maximum away from each other with 1 removed.
$square_mid_bottom = $square_max - (floor($square_size / 2));
$square_mid_left = $square_mid_bottom - ($square_size - 1);
$square_mid_top = $square_mid_left - ($square_size - 1);
$square_mid_right = $square_mid_top - ($square_size - 1);

// Calculate the distance from the input to each endpoint. Use absolute value
// so that all distances are positive.
$mid_bottom_dist = abs($input - $square_mid_bottom);
$mid_left_dist = abs($input - $square_mid_left);
$mid_top_dist = abs($input - $square_mid_top);
$mid_right_dist = abs($input - $square_mid_right);

// When we know the midpoints we need to calculate shortest distance from a
// midpoint to our value. After that we add the distance from that midpoint to
// the center. That gives is the Manhattan distance.
$min_midpoint_dist = min($mid_bottom_dist, $mid_left_dist, $mid_top_dist, $mid_right_dist);
$manhattan_dist = $min_midpoint_dist + (floor($square_size / 2));

// Stop timing
$end_time = microtime(true);

// Print results
echo("Result: " . $manhattan_dist . "\n");
echo("Execution time: " . ($end_time - $start_time) . " seconds");

?>
