<?php

/**
 * Class for problem part one
 *
 * @author Martin Björling <martinbjorling@gmail.com>
 * @license MIT
 * @copyright Martin Björling 2015 - 2017
 */
class PartTwo extends Base {
    private $moves;

    function __construct($input) {
        $this->moves = $input;
    }

    /**
     * dance
     *
     * Dance all programs one whole round of moves
     *
     * @param string[] $programs The programs at the start of the round
     * @param string[] $moves All moves made during the round
     * @return string The programs at the start of the round
     */
    private function dance(array $programs, array $moves) : array {
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
        return $programs;
    }

    /**
     * solve
     *
     * Solves the problem based on the input
     *
     * @return string The solution for the problem
     */
    public function solve() : string {
        // Fetch generators variable to save runtime
        // Get start value from each generator
        $moves = explode(",", $this->moves);

        // Initiate used
        $programs = range("a", "p");
        //$programs = range("a", "e"); // for testing only

        $programs_init = $programs;
        $programs_now = array();
        $roundtime = 0;

        // Find out the runtime (the time it takes to get the order back to
        // what it was when we begun). Assume that roundtime is less than
        // one billion.
        while ($programs_now !== $programs_init) {
            $roundtime++;

            $programs = $this->dance($programs, $moves);
            $programs_now = $programs;
        }

        // Get the remainder from one billion modulo roundtime
        $remainder = 1000000000 % $roundtime;

        // Run the whole dance "remainder times"
        for ($i=0; $i < $remainder; $i++) { 
            $programs = $this->dance($programs, $moves);
        }

        return implode("", $programs);
    }
}

?>
