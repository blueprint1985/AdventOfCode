<?php

class PartOne extends Base {
    private $spreadsheet;

    function __construct($input) {
        $this->spreadsheet = $input;
    }

    public function solve() {
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

        return $checksum;
    }
}

?>
