<?php

/**
 * Class for problem part one
 *
 * @author Martin Björling <martinbjorling@gmail.com>
 * @license MIT
 * @copyright Martin Björling 2015 - 2017
 */
class PartOne extends Base {
    private $grid;

    function __construct($input) {
        $this->grid = $input;
    }

    /**
     * walk
     *
     * Walk one step in the grid
     *
     * @param int $x The current $x coordinate
     * @param int $y The current $x coordinate
     * @param string $next_walk The current direction we are walking
     * @return int[] New coordinates after we walked one step
     */
    private function walk(int $x, int $y, string $next_walk) : array {
        // Change coordinate depending on walk direction
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

        return array($x, $y);
    }

    /**
     * turn
     *
     * Get next direction if we are turning
     *
     * @param string $curr_dir The current direction we are walking
     * @param bool $node_status If the current node is infected or not
     * @return string New direction based on previous direction
     */
    private function turn(string $curr_dir, bool $node_status) : string {
        $new_dir = "";

        // Turn depending on node status and previous direction
        switch ($curr_dir) {
            case 'right':
                $new_dir = ($node_status) ? "down" : "up";
                break;

            case 'up':
                $new_dir = ($node_status) ? "right" : "left";
                break;

            case 'left':
                $new_dir = ($node_status) ? "up" : "down";
                break;

            case 'down':
                $new_dir = ($node_status) ? "left" : "right";
                break;

            default:
                break;
        }

        return $new_dir;
    }

    /**
     * solve
     *
     * Solves the problem based on the input
     *
     * @return string The solution for the problem
     */
    public function solve() : string {
        // Fetch rules variable to save runtime
        $grid = array_map('str_split', $this->grid);

        // Initiate variables
        $y = floor(count($grid) / 2);
        $x = floor(count($grid[0]) / 2);
        $dir = "up";
        $caused_infection = 0;

        // Burst 10000 times
        for ($i=0; $i < 10000; $i++) {
            // Check if current node is infected or not
            $curr_node_infected = ($grid[$y][$x] == "#");

            // Turn depending on node status and current direction
            $dir = $this->turn($dir, $curr_node_infected);

            // Change node infection status and add to caused_infection if node
            // became infected
            if ($grid[$y][$x] === ".") {
                $grid[$y][$x] = "#";
                $caused_infection++;
            } else {
                $grid[$y][$x] = ".";
            }

            // Walk to next node
            list($x, $y) = $this->walk($x, $y, $dir);

            // If next node row is not present in the array, add it
            if (empty($grid[$y])) {
                $grid[$y] = array();
            }

            // If next node is not present in the array, add it
            if (empty($grid[$y][$x])) {
                $grid[$y][$x] = ".";
            }
        }

        return strval($caused_infection);
    }
}

?>
