<?php

/**
 * Class for problem part one
 *
 * @author Martin Björling <martinbjorling@gmail.com>
 * @license MIT
 * @copyright Martin Björling 2015 - 2017
 */
class PartTwo extends Base {
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

        // Initiate variables
        $pos = 0;
        $buffer_len = 1;
        $pos_one = 0;

        // Loop
        for ($i=1; $i <= 50000000; $i++) {
            // Calculate next position of insert
            $pos = (($pos + $steps) % $buffer_len) + 1;
            
            // If we stop at position 1, value at position 1 is i. We don't
            // need to know any other positions.
            if ($pos === 1) {
                $pos_one = $i;
            }

            // Increase buffer length
            $buffer_len++;
        }

        return strval($pos_one);
    }
}

?>
