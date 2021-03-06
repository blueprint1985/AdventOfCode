<?php

/**
 * Class for problem part one
 *
 * @author Martin Björling <martinbjorling@gmail.com>
 * @license MIT
 * @copyright Martin Björling 2015 - 2017
 */
class PartOne extends Base {
    private $moves;

    function __construct($input) {
        $this->moves = $input;
    }

    /**
     * move
     *
     * Move to adjacent hexagon according to direction
     *
     * @param string $move The direction to move
     * @param int[] $current The current hex coordinates
     * @return int[] New hex coordinates after move is made
     */
    private function move(string $move, array $current) : array {
        // Consider the axes to be the corners and not the edges
        switch ($move) {
            case 'n':
                $current['y']++;
                $current['z']--;
                break;
            case 'ne':
                $current['z']--;
                $current['x']++;
                break;

            case 'se':
                $current['x']++;
                $current['y']--;
                break;

            case 's':
                $current['y']--;
                $current['z']++;
                break;

            case 'sw':
                $current['z']++;
                $current['x']--;
                break;

            case 'nw':
                $current['x']--;
                $current['y']++;
                break;
            
            default:
                # code...
                break;
        }

        return $current;
    }

    /**
     * solve
     *
     * Solves the problem based on the input
     *
     * @return string The solution for the problem
     */
    public function solve() : string {
        // Fetch moves variable to save runtime
        $moves = explode(",", $this->moves);

        // Initiate current coordinate
        $current = array('x' => 0, 'y' => 0, 'z' => 0);

        // Loop through moves
        foreach ($moves as $move) {
            $current = $this->move($move, $current);
        }

        return strval((abs($current['x']) + abs($current['y']) + abs($current['z'])) / 2);
    }
}

?>
