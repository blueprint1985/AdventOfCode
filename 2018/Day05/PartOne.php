<?php

/**
 * Class for problem part one
 *
 * @author Martin Björling <martinbjorling@gmail.com>
 * @license MIT
 * @copyright Martin Björling 2015 - 2018
 */
class PartOne extends Base {
    private $polymer;

    function __construct($input) {
        $this->polymer = $input;
    }

    /**
     * compare
     *
     * Takes two strings and check if the are equal and one is uppercase and one is lowercase
     *
     * @param string $a The first string
     * @param string $b The second string
     * @return bool true if strings are equal and one is uppercase and one is lowercase, othewise false
     */
    private function compare(string $a, string $b) : bool {
        return (strtolower($a) === strtolower($b) && ((ctype_upper($a) && ctype_lower($b)) || ((ctype_lower($a) && ctype_upper($b)))));
    }

    /**
     * solve
     *
     * Solves the problem based on the input
     *
     * @return string The solution for the problem
     */
    public function solve() : string {
        // Fetch polymer variable to save runtime
        $polymer = $this->polymer;

        // Initiate variables
        $length = strlen($polymer);
        $i = 0;

        // Loop while we did not reach the end
        while ($i < $length) {
            if ($i === 0) {
                // Beginning of polymer string, compare first char with second
                if ($this->compare($polymer[$i], $polymer[$i + 1])) {
                    // We have a reaction
                    $polymer = substr($polymer, 2);
                    $length -= 2;
                } else {
                    // Check next
                    $i++;
                }
            } else if ($i === $length - 1) {
                // End of polymer string, compare last char with second to last
                if ($this->compare($polymer[$i], $polymer[$i - 1])) {
                    // We have a reaction
                    $polymer = substr($polymer, 0, $length - 2);
                    $length -= 2;
                } else {
                    // Check next
                    $i++;
                }
            } else {
                // Somewhere in the middle
                if ($this->compare($polymer[$i], $polymer[$i + 1])) {
                    // We have reaction with next char
                    $polymer = substr($polymer, 0, $i) . substr($polymer, $i + 2);
                    $length -= 2;
                    $i--;
                } else if ($this->compare($polymer[$i], $polymer[$i - 1])) {
                    // We have reaction with previous char
                    $polymer = substr($polymer, 0, $i - 1) . substr($polymer, $i + 1);
                    $length -= 2;
                    $i -= 2;
                } else {
                    // Check next
                    $i++;
                }
            }
        }

        return strval(strlen($polymer));
    }
}

?>
