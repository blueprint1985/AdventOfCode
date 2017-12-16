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
     * solve
     *
     * Solves the problem based on the input
     *
     * @return string The solution for the problem
     */
    public function solve() : string {
        // Fetch moves variable to save runtime
        // Split into array
        $moves = explode(",", $this->moves);

        // Initiate programs
        $programs = range("a", "p");
        //$programs = range("a", "e"); // for testing only

        // Loop moves
        foreach ($moves as $move) {
            $ab = substr($move, 1);
            $ab_arr = explode("/", $ab);

            if ($move[0] === "s") {
                // We are spinning, get spin size 
                $x = intval($ab_arr[0]);

                // Do the spin
                $tail = array_slice($programs, ($x * -1));
                $head = array_slice($programs, 0, ($x * -1));
                $programs = array_merge($tail, $head);
            } else if ($move[0] === "x") {
                // We are exchanging, get positions
                $a = intval($ab_arr[0]);
                $b = intval($ab_arr[1]);

                // Do the exchange
                $tmp = $programs[$a];
                $programs[$a] = $programs[$b];
                $programs[$b] = $tmp;
            } else if ($move[0] === "p") {
                // We are partnering, get positions
                $a = array_search($ab_arr[0], $programs);
                $b = array_search($ab_arr[1], $programs);

                // Do the partnering
                $tmp = $programs[$a];
                $programs[$a] = $programs[$b];
                $programs[$b] = $tmp;
            }
        }

        return implode("", $programs);
    }
}

?>
