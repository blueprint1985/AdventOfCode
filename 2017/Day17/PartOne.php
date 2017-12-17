<?php

/**
 * Class for problem part one
 *
 * @author Martin Björling <martinbjorling@gmail.com>
 * @license MIT
 * @copyright Martin Björling 2015 - 2017
 */
class PartOne extends Base {
    private $steps;

    function __construct($input) {
        $this->steps = $input;
    }

    /**
     * solve
     *
     * Solves the problem based on the input
     *
     * @return string The solution for the problem
     */
    public function solve() : string {
        // Fetch steps variable to save runtime
        $steps = intval($this->steps);

        // Initiate buffer and position
        $buffer = array(0);
        $pos = 0;

        // Loop
        for ($i=1; $i <= 2017; $i++) {
            // Calculate next position of insert and then insert next value at
            // that position
            $pos = (($pos + $steps) % count($buffer)) + 1;
            array_splice($buffer, $pos, 0, $i);
        }

        return strval($buffer[$pos+1]);
    }
}

?>
