<?php

class PartTwo extends Base {
    private $instructions;

    function __construct($input) {
        $this->instructions = $input;
    }

    /**
     * compare
     *
     * Compare two values accorting to operator, all are strings
     *
     * @param string $reg_val The left argumant of the comparison
     * @param string $operator The type of comparison to be done
     * @param string $comparator The right argumant of the comparison
     * @return bool the comparison result
     */
    private function compare(string $reg_val, string $operator, string $comparator) : bool {
        $code = 'return %s %s %s;';

        return eval(sprintf($code, $reg_val, $operator, $comparator));
    }

    public function solve() {
        // Fetch programs variable to save runtime
        $instructions = $this->instructions;

        // Initiate array and $highest
        $registers = array();
        $highest = 0;

        //Loop through instructions
        foreach ($instructions as $instruction) {
            // Get all parts of instruction
            list(
                $reg_to_change,
                $changer,
                $change_value,
                $if_string,
                $reg_to_read,
                $operator,
                $compare_value
            ) = explode(" ", $instruction);

            // Add register to change to array if it doesn't exist
            if (!array_key_exists($reg_to_change, $registers)) {
                $registers[$reg_to_change] = 0;
            }

            // Add register to read for comparison to array if it doesn't exist
            if (!array_key_exists($reg_to_read, $registers)) {
                $registers[$reg_to_read] = 0;
            }

            // Get both register values from array
            $change_reg_value = $registers[$reg_to_change];
            $read_reg_value = $registers[$reg_to_read];

            // Check if we should change the values or not, if we should,
            // change it according to the changer (inc, dec) and store in array
            if ($this->compare($read_reg_value, $operator, $compare_value)) {
                $registers[$reg_to_change] = ($changer === "inc") ?
                    $change_reg_value + intval($change_value) :
                    $change_reg_value - intval($change_value);
            }

            // Check if current array highest is higher than our stored highest
            $highest = max($highest, max($registers));
        }

        return $highest;
    }
}

?>
