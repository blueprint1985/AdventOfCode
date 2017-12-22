<?php

/**
 * Class for problem part two
 *
 * @author Martin Björling <martinbjorling@gmail.com>
 * @license MIT
 * @copyright Martin Björling 2015 - 2017
 */
class PartTwo extends Base {
    private $grid;

    function __construct($input) {
        $this->grid = $input;
        //$this->grid = explode("\n", ".........\n.........\n.........\n.....#...\n...#.....\n.........\n.........\n.........");
    }

    private function printGrid($grid, $x, $y)
    {
        foreach ($grid as $row_ind => $row) {
            if ($row_ind == $y) {
                $row[$x] = '['.$row[$x].']';
            }

            echo implode(" ", $row).PHP_EOL;
        }

        echo PHP_EOL;
    }

    /**
     * walk
     *
    * Walk one step in the grid
     *
     * @param int $x The current $x coordinate
     * @param int $y The current $x coordinate
     * @param string $next_walk The current direction we are walking
     * @return string New coordinates after we walked one step
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
     * @param string $node THe current node status
     * @return string New direction based on previous direction
     */
    private function turn(string $curr_dir, string $node) : string {
        // Don't turn if node status is "weakened"
        if ($node === "W") {
            return $curr_dir;
        }

        $new_dir = "";

        // Turn depending on node status and previous direction
        switch ($curr_dir) {
            case 'right':
                if ($node === "#") {
                    $new_dir = "down";
                } else if ($node === ".") {
                    $new_dir = "up";
                } else {
                    $new_dir = "left";
                }
                break;

            case 'up':
                if ($node === "#") {
                    $new_dir = "right";
                } else if ($node === ".") {
                    $new_dir = "left";
                } else {
                    $new_dir = "down";
                }
                break;

            case 'left':
                if ($node === "#") {
                    $new_dir = "up";
                } else if ($node === ".") {
                    $new_dir = "down";
                } else {
                    $new_dir = "right";
                }
                break;

            case 'down':
                if ($node === "#") {
                    $new_dir = "left";
                } else if ($node === ".") {
                    $new_dir = "right";
                } else {
                    $new_dir = "up";
                }
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
        for ($i=0; $i < 10000000; $i++) {
            // Get current node status
            $curr_node_status = $grid[$y][$x];

            // Turn depending on node status and current direction
            $dir = $this->turn($dir, $curr_node_status);

            // Change node infection status and add to caused_infection if node
            // became infected
            if ($grid[$y][$x] === ".") {
                $grid[$y][$x] = "W";
            } else if ($grid[$y][$x] === "W") {
                $grid[$y][$x] = "#";
                $caused_infection++;
            } else if ($grid[$y][$x] === "#") {
                $grid[$y][$x] = "F";
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
