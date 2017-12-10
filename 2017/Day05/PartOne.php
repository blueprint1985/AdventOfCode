<?php

/**
 * Class for problem part one
 *
 * $author Martin Björling <martinbjorling@gmail.com>
 * @license MIT
 * @copyright Martin Björling 2015 - 2017
 */
class PartOne extends Base {
    private $instructions;

    function __construct($input) {
        $this->instructions = array_map('intval', $input);
    }

    /**
     * solve
     *
     * Solves the problem based on the input
     *
     * @return string The solution for the problem
     */
    public function solve() : string {
        // Fetch instructions variable to save runtime
        $instructions = $this->instructions;

        // Initiate variables
        $pos = 0;
        $max_pos = count($instructions) - 1;
        $i = 0;

        // Loop though each password
        while ($pos <= $max_pos) {
            // Move position by the value of the current position
            $old_pos = $pos;
            $pos += $instructions[$pos];

            // Increase last position's value
            $instructions[$old_pos]++;

            $i++;
        }

        return strval($i);
    }
}

?>
