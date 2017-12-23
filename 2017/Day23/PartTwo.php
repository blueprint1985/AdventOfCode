<?php

/**
 * Class for problem part two
 *
 * @author Martin Björling <martinbjorling@gmail.com>
 * @license MIT
 * @copyright Martin Björling 2015 - 2017
 */
class PartTwo extends Base {
    private $instructions;

    function __construct($input) {
        $this->instructions = $input;
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
        // Below initiates variables needed for instruction 0-9
        $reg_keys = array('a', 'b', 'c', 'g', 'h');
        $registers = array_fill_keys($reg_keys, 0);
        $b_init = explode(" ", $instructions[0])[2];
        $registers['a'] = 1;
        $registers['b'] = $b_init * 100 + 100000;
        $registers['c'] = $registers['b'] + 17000;

        // Instructions 10 and above are looped, they are run several times due
        // to the jump in instruction 31
        do {
            // Reset register f to 1 (prime number is default)
            $registers['f'] = 1;

            // Instructions 10-24 is a loop that calculates if register b is a
            // prime number or not, first check if b is divisible by 2
            if ($registers['b'] % 2 !== 0) {
                // Odd number, check all odd numbers from 3 to half the value
                // of b, increase h if b is not a prime number
                for ($i = 3; $i < ceil($registers['b'] / 2); $i+=2) {
                    if ($registers['b'] % $i === 0) {
                        $registers['h']++;
                        break;
                    }
                }
            } else {
                // Even numbers are never prime numbers, increase h
                $registers['h']++;
            }

            // The rest of the instructions
            $registers['g'] = $registers['b'] - $registers['c'];
            $registers['b'] += 17;
        } while ($registers['g'] !== 0);

        return strval($registers['h']);
    }
}

?>
