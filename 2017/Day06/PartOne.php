<?php

class PartOne extends Base {
    private $banks;

    function __construct($input) {
        $this->banks = array_map("intval", explode("\t", $input));
    }

    public function solve() {
        // Fetch banks variable to save runtime
        $banks = $this->banks;

        // Initiate variables
        $prev_states = array();
        $banks_count = count($banks);
        $last_state = json_encode($banks);
        $i = 0;

        // Loop until last state is found amongst all previous states
        while (!in_array($last_state, $prev_states)) {
            // Add last state to previous states
            $prev_states[] = $last_state;

            // Find the bank with largest amount of blocks, find index of that bank and
            // set that bank to 0
            $max_blocks = max($banks);
            $max_pos = array_search($max_blocks, $banks);
            $banks[$max_pos] = 0;

            // Find how many new blocks all banks will get and blocks that will only be
            // given to banks "after" the current
            $add_all = floor($max_blocks / $banks_count);
            $add_rest = $max_blocks % $banks_count;

            // Add amount to all banks if we should
            if ($add_all > 0) {
                foreach ($banks as $key => $value) {
                    $banks[$key] = $value + $add_all;
                }
            }

            // Add 1 to banks after current, add_rest shows how many banks will get
            // more blocks
            $k = $max_pos + 1;
            for ($j = 0; $j < $add_rest; $j++) { 
                // If we reach the end, go to the beginning
                $k = ($k > $banks_count-1) ? 0 : $k;
                $banks[$k]++;
                $k++;
            }

            // Encode the current state of all banks, since we will compare it with
            // previous states and it's easier to have a string to compare with
            $last_state = json_encode($banks);

            // Increase our counter
            $i++;
        }

        return $i;
    }
}

?>
