<?php

/**
 * Class for problem part one
 *
 * @author Martin Björling <martinbjorling@gmail.com>
 * @license MIT
 * @copyright Martin Björling 2015 - 2017
 */
class PartOne extends Base {
    private $passwords;

    function __construct($input) {
        $this->passwords = $input;
    }

    /**
     * solve
     *
     * Solves the problem based on the input
     *
     * @return string The solution for the problem
     */
    public function solve() : string {
        // Fetch passwords variable to save runtime
        $passwords = $this->passwords;

        // Initiate correct
        $correct = 0;

        // Loop though each password
        foreach ($passwords as $pass) {
            // Convert the password to array and check for duplicates by flipping array
            // and since an array must have unique keys, if there are any duplicates,
            // the flipped array will be shorter
            $pass_split = explode(" ", $pass);
            if (count($pass_split) === count(array_flip($pass_split))) {
                $correct++;
            }
        }

        return strval($correct);
    }
}

?>
