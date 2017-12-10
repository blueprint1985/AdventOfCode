<?php

/**
 * Class for problem part one
 *
 * $author Martin Björling <martinbjorling@gmail.com>
 * @license MIT
 * @copyright Martin Björling 2015 - 2017
 */
class PartOne extends Base {
    private $list;

    function __construct($input) {
        $this->list = str_split($input);
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
        $list = $this->list;

        // Initiate variables
        $sum = 0;
        $i = 0;
        $list_len_short = count($list) - 1;

        // Loop though all elements except the last one
        while ($i < $list_len_short) { 
            // Compare the current element with next
            // If they are the same, add to sum
            if ($list[$i] === $list[$i+1]) {
                $sum += intval($list[$i], 10);
            }

            $i++;
        }

        // Compare the last element with the first
        // If they are the same, add to sum
        if ($list[$i] === $list[0]) {
            $sum += intval($list[$i], 10);
        }

        return strval($sum);
    }
}

?>
