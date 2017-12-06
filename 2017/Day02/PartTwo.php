<?php

class PartTwo extends Base {
    private $spreadsheet;

    function __construct($input) {
        $this->spreadsheet = $input;
    }

    public function solve() {
        // Fetch spreadsheet variable to save runtime
        $spreadsheet = $this->spreadsheet;

        // Initiate result
        $result = 0;

        // Loop though each row in the spreadsheet
        foreach ($spreadsheet as $row) {
            // Convert the row to array and calculate checksum for the row
            // Also get array_values since we need index to be reset
            // Get length of row
            $clean_row = array_values(array_filter(explode(" ", $row)));
            $length = count($clean_row);

            // Outer loop loops entire row except last element
            // Inner loop loops all elements after outer row current index
            for ($i = 0; $i < $length - 1; $i++) {
                for ($j = $i + 1; $j < $length; $j++) {
                    // Put current elements into array for easier comparint
                    $values = array($clean_row[$i], $clean_row[$j]);

                    // Compare values
                    // If divisible, add division to result
                    if (max($values) % min($values) === 0) {
                        $result += max($values) / min($values);
                    }
                }
            }
        }

        return $result;
    }
}

?>
