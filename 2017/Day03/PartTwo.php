<?php

/**
 * Class for problem part two
 *
 * $author Martin Björling <martinbjorling@gmail.com>
 * @license MIT
 * @copyright Martin Björling 2015 - 2017
 */
class PartTwo extends Base {
    private $square;

    function __construct($input) {
        $this->square = $input;
    }

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
    private function walk(int $x, int $y, string $next_walk) : string {
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
    private function calc(int $x, int $y, array $square) : int {
        $curr_add = 0;

        // Loop through x-values
        for ($i=-1; $i < 2; $i++) {
            $x_n = $x + $i;

            // Loop through y-values
            for ($j=-1; $j < 2; $j++) {
                $y_n = $y + $j;

                // Create coordinate from loop values
                $check_coord = $x_n.":".$y_n;

                // Do not add if coordinate is not calculated or same as
                // the original coordinate in function call
                if (($x_n === $x && $y_n === $y) || !array_key_exists($check_coord, $square)) {
                    continue;
                }

                // Add coordinate value to sum
                $curr_add += intval($square[$check_coord]);
            }
        }

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
    private function turn(string $next_walk) : string {
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

    /**
     * solve
     *
     * Solves the problem based on the input
     *
     * @return string The solution for the problem
     */
    public function solve() : string {
        // Convert square to int
        $square = intval($this->square);

        // Initiate variables
        $grid = array("0:0" => 1);
        $next_walk = "right";
        $curr_pos = "0:0";
        $curr_add = 0;

        // Make a spiral walkthough starting from center
        while ($curr_add <= $square) {
            // Get current coordinates from string
            list($x, $y) = explode(":", $curr_pos);

            // Go to next coordinates
            $curr_pos = $this->walk($x, $y, $next_walk);

            // Get coordinates again for next. Need to be ints for comparison
            list($x, $y) = explode(":", $curr_pos);
            $x = intval($x);
            $y = intval($y);

            // Calculate coordinate value and store in grid array
            $curr_add = $this->calc($x, $y, $grid);
            $grid[$curr_pos] = $curr_add;

            // Turn if we have the following conditions:
            // - Upper right or lower left corner ($x === $y*-1)
            // - Upper left corner ($x and $y negative and equal)
            // - One right of lower right corner, we have expanded edge of grid, ($x and $y positive, $x is 1 larger than $y)
            if ($x === $y*-1 || ($x < 0 && $x === $y) || ($x > 0 && $x === $y+1)) {
                $next_walk = $this->turn($next_walk);
            }
        }

        return strval($curr_add);
    }
}

?>
