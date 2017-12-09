<?php

class PartTwo extends Base {
    private $stream;

    function __construct($input) {
        $this->stream = $input;
    }

    public function solve() {
        // Fetch programs variable to save runtime
        $stream = $this->stream;

        $garbage = 0;
        $i = 0;

        // Loop through entire stream
        while ($i < strlen($stream)) {
            $i++;

            // If current char is start if garbage, find garbage end
            if (isset($stream[$i]) && $stream[$i] === "<") {
                $i++;
                $cancel_next = false;
                $garbage_ended = false;

                // Search until we find end of garbage
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

                    // Otherwise, increase garbage amount and i
                    $garbage++;
                    $i++;
                }
            }
        }

        return $garbage;
    }
}

?>
