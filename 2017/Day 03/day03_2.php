<?php

/**
 * walk
 * 
 * Calculate the shortest distance to a midpoint.
 *
 * @param int $x The current $x coordinate
 * @param int $y The current $x coordinate
 * @param string $next_walk The current direction we are walking
 * @return string New coordinates after we walked one step
 */
function walk(int $x, int $y, string $next_walk) : string {
    switch ($next_walk) {
        case 'right':
            $x++;
            break;

        case 'up':
            $y--;
            break;

        case 'left':
            $x--;
            break;

        case 'down':
            $y++;
            break;
        
        default:
            break;
    }

    return $x.":".$y;
}

/**
 * calc
 * 
 * Calculate current square as sum of adjacent squares.
 * Non existing squares are considered having value 0.
 *
 * @param int $x The current $x coordinate
 * @param int $y The current $x coordinate
 * @param string[] $square All values for the square calculated so far
 * @return int The calculated value for the coordinate
 */
function calc(int $x, int $y, array $square) : int {
    $curr_add = 0;

    $curr_add += intval($square[($x+1) . ":" . ($y  )]);
    $curr_add += intval($square[($x+1) . ":" . ($y-1)]);
    $curr_add += intval($square[($x  ) . ":" . ($y-1)]);
    $curr_add += intval($square[($x-1) . ":" . ($y-1)]);
    $curr_add += intval($square[($x-1) . ":" . ($y  )]);
    $curr_add += intval($square[($x-1) . ":" . ($y+1)]);
    $curr_add += intval($square[($x  ) . ":" . ($y+1)]);
    $curr_add += intval($square[($x+1) . ":" . ($y+1)]);

    return $curr_add;
}

/**
 * turn
 * 
 * Get next direction if we are turning 
 *
 * @param string $next_walk The current direction we are walking
 * @return string New direction based on precious direction
 */
function turn(string $next_walk) : string {
    $turn = "";

    switch ($next_walk) {
        case 'right':
            $turn = "up";
            break;

        case 'up':
            $turn = "left";
            break;

        case 'left':
            $turn = "down";
            break;

        case 'down':
            $turn = "right";
            break;
        
        default:
            break;
    }

    return $turn;
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

// Initiate variables
$square = array("0:0" => 1);
$next_walk = "right";
$curr_pos = "0:0";
$curr_add = 0;

// Make a spiral walkthough starting from center
while ($curr_add <= $input) {
    // Get current coordinates from string
    list($x, $y) = explode(":", $curr_pos);

    // Go to next coordinates
    $curr_pos = walk($x, $y, $next_walk);

    // Get coordinates again for next. Need to be ints for comparison
    list($x, $y) = explode(":", $curr_pos);
    $x = intval($x);
    $y = intval($y);

    // Calculate coordinate value and store in square array
    $curr_add = calc($x, $y, $square);
    $square[$curr_pos] = $curr_add;

    // Turn if we have the following conditions:
    // - Upper right or lower left corner ($x === $y*-1)
    // - Upper left corner ($x and $y negative and equal)
    // - One right of lower right corner, we have expanded edge of square, ($x and $y positive, $x is 1 larger than $y)
    if ($x === $y*-1 || ($x < 0 && $x === $y) || ($x > 0 && $x === $y+1)) {
        $next_walk = turn($next_walk);
    }
}

// Stop timing
$end_time = microtime(true);

// Print results
echo("Result: " . $curr_add . "\n");
echo("Execution time: " . ($end_time - $start_time) . " seconds");

?>
