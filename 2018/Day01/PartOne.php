<?php

/**
 * Class for problem part one
 *
 * @author Martin Björling <martinbjorling@gmail.com>
 * @license MIT
 * @copyright Martin Björling 2015 - 2017
 */
class PartOne extends Base {
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
        // Fetch list of changes to save runtime
        $changes = $this->changes;

        // Initiate frequency
        $freq = 0;

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
        }

        return strval($freq);
    }
}

?>
