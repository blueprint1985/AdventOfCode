<?php

/**
 * Class for problem part one
 *
 * @author Martin Björling <martinbjorling@gmail.com>
 * @license MIT
 * @copyright Martin Björling 2015 - 2017
 */
class PartOne extends Base {
    private $generators;

    function __construct($input) {
        $this->generators = $input;
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
        $generators = $this->generators;
        $genAarr = explode(" ", $generators[0]);
        $genBarr = explode(" ", $generators[1]);
        $genAval = intval(array_pop($genAarr));
        $genBval = intval(array_pop($genBarr));

        // Initiate used
        $matches = 0;

        // Make 40 million calculations
        for ($i=0; $i < 40000000; $i++) {
            // Get value for this round
            $genAval = ($genAval * 16807) % 2147483647;
            $genBval = ($genBval * 48271) % 2147483647;

            // Do bitwise AND for each generator value, the bitwise operator &
            // returns and integer. We can then compare both integers and check
            // if they are the same.
            if (($genAval & 0xffff) === ($genBval & 0xffff)) {
                $matches++;
            }
        }

        return strval($matches);
    }
}

?>
