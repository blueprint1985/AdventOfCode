<?php

class PartOne extends Base {
    private $stream;

    function __construct($input) {
        $this->stream = $input;
    }

    //private function -+

    public function solve() {
        // Fetch programs variable to save runtime
        $stream = $this->stream;

        // Initiate variables
        $sum = 0;
        $depth_counter = 0;
        $i = 0;

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
                $i++;
                $cancel_next = false;
                $garbage_ended = false;

                while (!$garbage_ended) {
                    // If this char was cancelled
                    if ($cancel_next) {
                        $cancel_next = false;
                        $i++;
                        continue;
                    }

                    // If this char is "!", cancel next
                    if ($stream[$i] === "!") {
                        $cancel_next = true;
                        $i++;
                        continue;
                    }

                    // If this char is ">" and not cancelled, we found the end
                    if ($stream[$i] === ">") {
                        $garbage_ended = true;
                        $i++;
                        continue;
                    }

                    // Otherwise, increase  i
                    $i++;
                }
            }
        }

        return $sum;
    }
}

?>
