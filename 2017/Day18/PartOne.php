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
     * initProgram
     *
     * Initiates all regusters and set their value to 0
     *
     * @param string[] $instructions All instructions
     * @return string The solution for the problem
     */
    private function initProgram($instructions) {
        // Initiate registers
        $registers = array();

        // Loop instructions
        foreach ($instructions as $instr) {
            $instr_arr = explode(" ", $instr);

            // If first value in instruction is a non numerical char and we
            // don't have that in register array, save it with value 0
            if (isset($instr_arr[1]) && !is_numeric($instr_arr[1]) && !array_key_exists($instr_arr[1], $registers)) {
                $registers[$instr_arr[1]] = 0;
            }

            // If second value in instruction is a non numerical char and we
            // don't have that in register array, save it with value 0
            if (isset($instr_arr[2]) && !is_numeric($instr_arr[2]) && !array_key_exists($instr_arr[2], $registers)) {
                $registers[$instr_arr[2]] = 0;
            }
        }

        return $registers;
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
        $registers = $this->initProgram($instructions);
        $last_played = 0;
        $pos = 0;

        // End loop if we pass last instruction
        while ($pos < count($instructions)) {
            // Get instructions per position
            $instr = explode(" ", $instructions[$pos]);

            // Sound
            if ($instr[0] === "snd") {
                // Save "last played"
                $last_played = $registers[$instr[1]];
            }

            // Set
            else if ($instr[0] === "set") {
                // Check if we have a numerical value or take it from a
                // register
                $registers[$instr[1]] =
                    is_numeric($instr[2]) ?
                    intval($instr[2]) :
                    $registers[$instr[2]];
            }

            // Add
            else if ($instr[0] === "add") {
                // Check if we have a numerical value or take it from a
                // register
                $registers[$instr[1]] +=
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
            } 

            // Modulo
            else if ($instr[0] === "mod") {
                // Check if we have a numerical value or take it from a
                // register
                $registers[$instr[1]] %=
                    is_numeric($instr[2]) ?
                    intval($instr[2]) :
                    $registers[$instr[2]];

            }

            // Recover
            else if ($instr[0] === "rcv") {
                // Break loop when we get here
                if ($registers[$instr[1]] !== 0) {
                    break;
                }
            }

            // Jump
            else if ($instr[0] === "jgz") {
                // Change position, then make "continue"
                // Check if we have a numerical value or take it from a
                // register
                $compare =
                    is_numeric($instr[1]) ?
                    intval($instr[1]) :
                    $registers[$instr[1]];

                if ($compare > 0) {
                    // Check if we have a numerical value or take it from a
                    // register
                    $pos += is_numeric($instr[2]) ? intval($instr[2]) : $registers[$instr[2]];
                    continue;
                }
            }

            // Increase position
            $pos++;
        }

        return strval($last_played);
    }
}

?>
