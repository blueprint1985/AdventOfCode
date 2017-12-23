<?php

/**
 * Class for problem part one
 *
 * @author Martin Björling <martinbjorling@gmail.com>
 * @license MIT
 * @copyright Martin Björling 2015 - 2017
 */
class PartOne extends Base {
    private $instructions;

    function __construct($input) {
        $this->instructions = $input;
    }

    /**
     * solve
     *
     * Solves the problem based on the input
     *
     * @return string The solution for the problem
     */
    public function solve() : string {
        // Fetch instructions variable to save runtime
        $instructions = $this->instructions;

        // Initiate variables
        $reg_keys = range('a', 'h');
        $registers = array_fill_keys($reg_keys, 0);
        $pos = 0;
        $mul_count = 0;

        // End loop if we pass last instruction
        while ($pos < count($instructions)) {
            // Get instructions per position
            $instr = explode(" ", $instructions[$pos]);

            // Set
            if ($instr[0] === "set") {
                // Check if we have a numerical value or take it from a
                // register
                $registers[$instr[1]] =
                    is_numeric($instr[2]) ?
                    intval($instr[2]) :
                    $registers[$instr[2]];
            }

            // Sub
            else if ($instr[0] === "sub") {
                // Check if we have a numerical value or take it from a
                // register
                $registers[$instr[1]] -=
                    is_numeric($instr[2]) ?
                    intval($instr[2]) :
                    $registers[$instr[2]];
            }

            // Multiply
            else if ($instr[0] === "mul") {
                // Check if we have a numerical value or take it from a
                // register
                $registers[$instr[1]] *=
                    is_numeric($instr[2]) ?
                    intval($instr[2]) :
                    $registers[$instr[2]];

                // Increase mutliply count
                $mul_count++;
            }

            // Jump
            else if ($instr[0] === "jnz") {
                // Change position, then make "continue"
                // Check if we have a numerical value or take it from a
                // register
                $compare =
                    is_numeric($instr[1]) ?
                    intval($instr[1]) :
                    $registers[$instr[1]];

                if ($compare !== 0) {
                    // Check if we have a numerical value or take it from a
                    // register
                    $pos += is_numeric($instr[2]) ? intval($instr[2]) : $registers[$instr[2]];
                    continue;
                }
            }

            // Increase position
            $pos++;
        }

        return strval($mul_count);
    }
}

?>
