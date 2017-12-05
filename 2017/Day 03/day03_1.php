<?php

/**
 * shortestDistToMid
 * 
 * Calculate the shortest distance to a midpoint.
 *
 * @param int $input The input that we need to know the Manhattan distance from
 * @param int[] $midpoints Array containing the four midpoints on the edge of the square
 * @param int $square_size The width and height of the square
 * @return int The shortest distance from the input to a midpoint
 */
function shortestDistToMid(int $input, array $midpoints, int $square_size) : int {
    $distance = $square_size;

    foreach ($midpoints as $value) {
        $distance = min($distance, abs($input - $value));
    }

    return $distance;
}

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

// When we know the midpoints we need to calculate shortest distance from a
// midpoint to our value. After that we add the distance from that midpoint to
// the center. That gives is the Manhattan distance.
$midpoints = array($square_mid_bottom, $square_mid_left, $square_mid_top, $square_mid_right);
$midpoint_dist = shortestDistToMid($input, $midpoints, $square_size);
$manhattan_dist = $midpoint_dist + (floor($square_size / 2));

// Stop timing
$end_time = microtime(true);

// Print results
echo("Result: " . $manhattan_dist . "\n");
echo("Execution time: " . ($end_time - $start_time) . " seconds");

?>
