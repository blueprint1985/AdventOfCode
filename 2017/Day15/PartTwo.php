<?php

/**
 * Class for problem part two
 *
 * @author Martin Björling <martinbjorling@gmail.com>
 * @license MIT
 * @copyright Martin Björling 2015 - 2017
 */
class PartTwo extends Base {
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

        // Ran out of memory (started with 128M)
        ini_set('memory_limit','1024M');

        // Initiate variables
        $matches = 0;
        $genAmod = array();
        $genBmod = array();

        // Populate both generator valid arrays
        while (count($genAmod) <= 5000000 || count($genBmod) <= 5000000) {
            // Only calc if we have 5 million or less valid
            if (count($genAmod) <= 5000000) {
                // Get value for this round
                $genAval = ($genAval * 16807) % 2147483647;

                // Only add if it's divisible by 4
                if ($genAval % 4 === 0) {
                    $genAmod[] = $genAval;
                }
            }

            // Only calc if we have 5 million or less valid
            if (count($genBmod) <= 5000000) {
                // Get value for this round
                $genBval = ($genBval * 48271) % 2147483647;

                // Only add if it's divisible by 8
                if ($genBval % 8 === 0) {
                    $genBmod[] = $genBval;
                }
            }
        }

        // Compare all pairs
        for ($i=0; $i < 5000000; $i++) {
            // Do bitwise AND for each generator value, the bitwise operator &
            // returns and integer. We can then compare both integers and check
            // if they are the same.
            if (($genAmod[$i] & 0xffff) === ($genBmod[$i] & 0xffff)) {
                $matches++;
            }
        }

        return strval($matches);
    }
}

?>
