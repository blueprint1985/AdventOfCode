<?php

/**
 * Class for problem part one
 *
 * @author Martin Björling <martinbjorling@gmail.com>
 * @license MIT
 * @copyright Martin Björling 2015 - 2017
 */
class PartOne extends Base {
    private $stream;

    function __construct($input) {
        $this->stream = $input;
    }

    /**
     * garbageHandler
     *
     * Find the end position of the garbage
     *
     * @param int $pos Garbage start position
     * @param string $stream Full stream
     * @return int Garbage end position
     */
    private function garbageHandler(int $pos, string $stream) : int {
        $pos++;
        $cancel_next = false;
        $garbage_ended = false;

        // Search until we find end of garbage
        while (!$garbage_ended) {
            // If this char was cancelled
            if ($cancel_next) {
                $cancel_next = false;
                $pos++;
                continue;
            }

            // If this char is "!", cancel next
            if ($stream[$pos] === "!") {
                $cancel_next = true;
                $pos++;
                continue;
            }

            // If this char is ">" and not cancelled, we found the end
            if ($stream[$pos] === ">") {
                $garbage_ended = true;
                $pos++;
                continue;
            }

            // Otherwise, increase pos
            $pos++;
        }

        return $pos;
    }

    /**
     * solve
     *
     * Solves the problem based on the input
     *
     * @return string The solution for the problem
     */
    public function solve() : string {
        // Fetch programs variable to save runtime
        $stream = $this->stream;

        // Initiate variables
        $sum = 0;
        $depth_counter = 0;
        $i = 0;

        // If we actually have garbage before the first group
        if (isset($stream[$i]) && $stream[$i] === "<") {
            $i = $this->garbageHandler($i, $stream);
        }

        // Loop through entire stream
        while ($i < strlen($stream)) {
            // We found a valid group start, increase depth counter and add to
            // total sum, or a valid group ending, decrease depth counter
            if (isset($stream[$i]) && $stream[$i] === "{") {
                $depth_counter++;
                $sum += $depth_counter;
            } else if (isset($stream[$i]) && $stream[$i] === "}") {
                $depth_counter--;
            }

            $i++;

            // If current char is start if garbage, find garbage end
            if (isset($stream[$i]) && $stream[$i] === "<") {
                $i = $this->garbageHandler($i, $stream);
            }
        }

        return strval($sum);
    }
}

?>
