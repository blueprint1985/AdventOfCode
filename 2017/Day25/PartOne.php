<?php

/**
 * Class for problem part one
 *
 * @author Martin Björling <martinbjorling@gmail.com>
 * @license MIT
 * @copyright Martin Björling 2015 - 2017
 */
class PartOne extends Base {
    private $blueprint;

    function __construct($input) {
        $this->blueprint = $input;
    }

    /**
     * parseBlueprint
     *
     * Parses the input blueprint into array where each state is key and value
     * is an array with two elements where keys are 0 and 1 (possible values
     * for a tape element)
     *
     * @param string[] $blueprint The input blueprint
     * @return array[] The blueprint as array
     */
    private function parseBlueprint(array $blueprint) : array {
        // remove flrst three lines in blueprint and get length
        $blueprint = array_slice($blueprint, 3);
        $blueprint_length = count($blueprint);

        // Init counter and blueprint array
        $i = 0;
        $blueprint_arr = array();

        // Loop through blueprint
        while ($i <= $blueprint_length) {
            if ($i % 10 === 0) {
                // If counter mod 10 is 0, new state
                $state_key = explode(" ", $blueprint[$i])[2];
                $state_key = $state_key[0];
                $blueprint_arr[$state_key] = array();
            } else if ($i % 10 === 1 || $i % 10 === 5) {
                // If counter mod 10 is 1 or 5, current value
                $state_val = explode(" ", trim($blueprint[$i]))[5];
                $state_val = intval($state_val[0]);
                $blueprint_arr[$state_key][$state_val] = array();
            } else if ($i % 10 === 2 || $i % 10 === 6) {
                // If counter mod 10 is 2 or 6, new value
                $state_write = explode(" ", trim($blueprint[$i]))[4];
                $state_write = $state_write[0];
                $blueprint_arr[$state_key][$state_val]["write"] = intval($state_write);
            } else if ($i % 10 === 3 || $i % 10 === 7) {
                // If counter mod 10 is 3 or 7, move direction
                $state_move = explode(" ", trim($blueprint[$i]))[6];
                $state_move = $state_move[0];
                $blueprint_arr[$state_key][$state_val]["move"] = $state_move;
            } else if ($i % 10 === 4 || $i % 10 === 8) {
                // If counter mod 10 is 4 or 8, next state
                $state_next = explode(" ", trim($blueprint[$i]))[4];
                $state_next = $state_next[0];
                $blueprint_arr[$state_key][$state_val]["next"] = $state_next;
            }

            $i++;
        }

        return $blueprint_arr;
    }

    /**
     * solve
     *
     * Solves the problem based on the input
     *
     * @return string The solution for the problem
     */
    public function solve() : string {
        // Fetch blueprint variable to save runtime
        // Get exit condition
        // Parse blueprint into array
        $exit = intval(explode(" ", $this->blueprint[1])[5]);
        $blueprint = $this->parseBlueprint($this->blueprint);

        // Init variables
        $state = "A";
        $tape = array(0);
        $pos = 0;

        // Loop until exit condition
        for ($i=0; $i < $exit; $i++) {
            // Get value at current position
            $tape_val = $tape[$pos];

            // Get instructions for state / position value
            $instr = $blueprint[$state][$tape_val];

            // Write new value to position
            $tape[$pos] = $instr["write"];

            // Move position
            $pos = ($instr["move"] === "r") ? $pos+1 : $pos-1;

            // Crete new tape element if not exists
            if (empty($tape[$pos])) {
                $tape[$pos] = 0;
            }

            // Update state
            $state = $instr["next"];
        }

        // Get sum of tape
        return strval(array_sum($tape));
    }
}

?>
