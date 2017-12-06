<?php

class PartOne extends Base {
    private $passwords;

    function __construct($input) {
        $this->passwords = $input;
    }

    public function solve() {
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

        return $correct;
    }
}

?>
