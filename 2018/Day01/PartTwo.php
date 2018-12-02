<?php

/**
 * Class for problem part two
 *
 * @author Martin Björling <martinbjorling@gmail.com>
 * @license MIT
 * @copyright Martin Björling 2015 - 2017
 */
class PartTwo extends Base {
    private $changes;

    function __construct($input) {
        $this->changes = $input;
    }

    /**
     * solve
     *
     * Solves the problem based on the input
     *
     * @return string The solution for the problem
     */
    public function solve() : string {
        // Fetch list variable to save runtime
        $changes = $this->changes;

        // Initiate variables
        $freq = 0;
        $value = 0;
        $reached = false;
        $reachedFreqs = [];

        // Loop while same frequency not yet reached
        while (!$reached) {

            // Loop all changes
            foreach ($changes as $change) {
                $sign = substr($change, 0, 1);
                $value = (int) substr($change, 1);

                // Change frequency according to change
                if ($sign === '+') {
                    $freq += $value;
                } else {
                    $freq -= $value;
                }

                // Chheck if we have already been at that frequency
                if (in_array($freq, $reachedFreqs)) {
                    $reached = true;
                    break;
                }

                // Add that frequency to list of visited frequencies
                $reachedFreqs[] = $freq;
            }
        }

        return strval($freq);
    }
}

?>
