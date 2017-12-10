<?php

/**
 * Class for problem part one
 *
 * $author Martin Björling <martinbjorling@gmail.com>
 * @license MIT
 * @copyright Martin Björling 2015 - 2017
 */
class PartOne extends Base {
    private $spreadsheet;

    function __construct($input) {
        $this->spreadsheet = $input;
    }

    /**
     * solve
     *
     * Solves the problem based on the input
     *
     * @return string The solution for the problem
     */
    public function solve() : string {
        // Fetch spreadsheet variable to save runtime
        $spreadsheet = $this->spreadsheet;

        // Initiate checksum
        $checksum = 0;

        // Loop though each row in the spreadsheet
        foreach ($spreadsheet as $row) {
            // Convert the row to array and calculate checksum for the row
            // Add to total checksum
            $clean_row = array_filter(explode(" ", $row));
            $checksum += (max($clean_row) - min($clean_row));
        }

        return strval($checksum);
    }
}

?>
