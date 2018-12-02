<?php

/**
 * Class for problem part one
 *
 * @author Martin Björling <martinbjorling@gmail.com>
 * @license MIT
 * @copyright Martin Björling 2015 - 2017
 */
class PartOne extends Base {
    private $ids;

    function __construct($input) {
        $this->ids = $input;
    }

    /**
     * solve
     *
     * Solves the problem based on the input
     *
     * @return string The solution for the problem
     */
    public function solve() : string {
        // Fetch ids variable to save runtime
        $ids = $this->ids;

        // Initiate variables
        $twos = 0;
        $threes = 0;

        // Loop though each row in the ids
        foreach ($ids as $id) {
            $id_arr = str_split($id);
            $value_amount = array_count_values($id_arr);

            // Check if we have any doubles
            if (in_array(2, $value_amount)) {
                $twos++;
            }

            // Check if we have any triples
            if (in_array(3, $value_amount)) {
                $threes++;
            }
        }

        return strval($twos * $threes);
    }
}

?>
