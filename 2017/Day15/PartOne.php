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

            // Convert to binary
            $genAbin = decbin($genAval);
            $genBbin = decbin($genBval);

            // Get the last 16 bits
            $genAend = substr($genAbin, -16);
            $genBend = substr($genBbin, -16);

            // Check for match
            if ($genAend === $genBend) {
                $matches++;
            }
        }

        return strval($matches);
    }
}

?>
