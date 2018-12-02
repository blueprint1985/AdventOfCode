<?php

/**
 * Class for problem part two
 *
 * @author Martin Björling <martinbjorling@gmail.com>
 * @license MIT
 * @copyright Martin Björling 2015 - 2017
 */
class PartTwo extends Base {
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
        $id_len = strlen($ids[0]);
        $has_same = false;

        // Loop for checking each character position
        for ($i=0; $i < $id_len; $i++) {
            $removed_arr = [];

            // Loop though each row in the ids and remove character at position i
            foreach ($ids as $id) {
                $removed_arr[] = substr_replace($id, '', $i, 1);
            }

            // Check if any string appears twice
            $value_amount = array_count_values($removed_arr);
            $has_same = array_search(2, $value_amount);

            // Stop if a string appears twice
            if ($has_same) {
                break;
            }
        }

        return strval($has_same);
    }
}

?>
