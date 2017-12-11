<?php

/**
 * Class for problem part two
 *
 * @author Martin Björling <martinbjorling@gmail.com>
 * @license MIT
 * @copyright Martin Björling 2015 - 2017
 */
class PartTwo extends Base {
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

        $sum = 0;
        $i = 0;
        $list_len = count($list);

        // Loop thouch all elements
        while ($i < $list_len) {
            // Compare the current element with one halfway around
            // If they are the same, add to sum
            if ($list[$i] === $list[($i+($list_len/2))%$list_len]) {
                $sum += intval($list[$i], 10);
            }

            $i++;
        }

        return strval($sum);
    }
}

?>
