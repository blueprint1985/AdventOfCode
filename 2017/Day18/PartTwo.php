<?php

/**
 * Class for problem part two
 *
 * @author Martin Björling <martinbjorling@gmail.com>
 * @license MIT
 * @copyright Martin Björling 2015 - 2017
 */
class PartTwo extends Base {
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

        // Initiate programs inside an array and set program 1 "p" to 1
        $registers = $this->initProgram($instructions);
        $program_ids = array(0,1);
        $programs = array($registers, $registers);
        $programs[1]["p"] = 1;

        // Initiate variables as arrays, one element per program
        $queue = array(array(), array());
        $pos = array(0, 0);
        $terminated = array(false, false);
        $blocked = array(false, false);
        $sent = array(0, 0);

        // Break loop if both programs are blocked or terminated
        while (!(($blocked[0] || $terminated[0]) && ($blocked[1] || $terminated[1]))) {
            // Get instructions per program position
            $instr = array(
                explode(" ", $instructions[$pos[0]]),
                explode(" ", $instructions[$pos[1]])
            );

            // Used if we jump this round for each program
            $jumped = array(false, false);

            // Do once for each program
            foreach ($program_ids as $i) {
                // Receive
                if ($instr[$i][0] === "rcv") {
                    // If we have things in queue, we are not blocked, store in
                    // correct register, else we are blocked
                    if (count($queue[$i]) > 0) {
                        $programs[$i][$instr[$i][1]] = array_shift($queue[$i]);
                        $blocked[$i] = false;
                    } else {
                        $blocked[$i] = true;
                    }
                }

                // Send
                else if ($instr[$i][0] === "snd") {
                    // Calc reciever 
                    $to = abs($i-1);

                    // Check if we have a numerical value or take it from a
                    // register
                    $queue[$to][] =
                        is_numeric($instr[$i][1]) ?
                        intval($instr[$i][1]) :
                        $programs[$i][$instr[$i][1]];

                    // Increase sent
                    $sent[$i]++;
                }
            
                // Set
                else if ($instr[$i][0] === "set") {
                    // Check if we have a numerical value or take it from a
                    // register
                    $programs[$i][$instr[$i][1]] =
                        is_numeric($instr[$i][2]) ?
                        intval($instr[$i][2]) :
                        $programs[$i][$instr[$i][2]];
                }

                // Add
                else if ($instr[$i][0] === "add") {
                    // Check if we have a numerical value or take it from a
                    // register
                    $programs[$i][$instr[$i][1]] +=
                        is_numeric($instr[$i][2]) ?
                        intval($instr[$i][2]) :
                        $programs[$i][$instr[$i][2]];
                }

                // Multiply
                else if ($instr[$i][0] === "mul") {
                    // Check if we have a numerical value or take it from a
                    // register
                    $programs[$i][$instr[$i][1]] *=
                        is_numeric($instr[$i][2]) ?
                        intval($instr[$i][2]) :
                        $programs[$i][$instr[$i][2]];
                }

                // Modulo
                else if ($instr[$i][0] === "mod") {
                    // Check if we have a numerical value or take it from a
                    // register
                    $programs[$i][$instr[$i][1]] %=
                        is_numeric($instr[$i][2]) ?
                        intval($instr[$i][2]) :
                        $programs[$i][$instr[$i][2]];
                }

                //Jump
                else if ($instr[$i][0] === "jgz") {
                    // Check if we have a numerical value or take it from a
                    // register
                    $compare =
                        is_numeric($instr[$i][1]) ?
                        intval($instr[$i][1]) :
                        $programs[$i][$instr[$i][1]];

                    // If our compare value is larger than 0
                    if ($compare > 0) {

                        // Check if we have a numerical value or take it from a
                        // register
                        $pos[$i] +=
                            is_numeric($instr[$i][2]) ?
                            intval($instr[$i][2]) :
                            $programs[$i][$instr[$i][2]];

                        // We jumoed
                        $jumped[$i] = true;
                    }
                }

                // Increase position if we are not blocked and didn't jump
                if (!$jumped[$i] && !$blocked[$i]) {
                    $pos[$i]++;
                }

                // If we are outside instructions, program was terminated and
                // we don't need to check it anymore
                if ($pos[$i] >= count($instructions)) {
                    $terminated[$i] = true;
                    unset($program_ids[$i]);
                }
            }
        }

        return strval($sent[1]);
    }
}

?>
