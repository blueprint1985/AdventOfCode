<?php

class PartOne extends Base {
    private $lengths;

    function __construct($input) {
        $this->lengths = $input;
    }



    public function solve() {
        // Fetch programs variable to save runtime
        $lengths = array_map("intval", explode(",", $this->lengths));

        // Initiate variables
        $list = range(0, 4); // For testing only!
        //$list = range(0, 255); // For testing only!
        $skip_size = 0;
        $list_pos = 0;
        $list_len = count($list);
        $list_max = $list_len - 1;

        // Go through each length
        foreach ($lengths as $i => $length) {
            // If length is 1, we don't need to do anything, just increase
            // position and skip size
            if ($length === 1) {
                // We need to wrap position if we are going outside the list
                // length, then increase skip_size by 1
                $list_pos = (($list_pos + $length + $skip_size) % $list_len);
                $skip_size++;
                continue;
            }

            // If the sub list we are looking for ends before the end of the
            // list (not wrapping around) we can just get the correct slice
            // and reverse it. Otherwise we need to get the tail and head of
            // the list as the sub list.
            if ($list_pos + $length <= $list_max) {
                // Get sub list, reverse it and put it back.
                $sub_list = array_slice($list, $list_pos, $length);
                $rev_list = array_reverse($sub_list);
                array_splice($list, $list_pos, $length, $rev_list);
            } else {
                // Get the tail and head lengths
                $tail_length = $list_len - $list_pos;
                $head_length = $length - $tail_length;

                // Get the actual tail ahd head lists
                $tail_list = array_slice($list, $list_pos);
                $head_list = array_slice($list, 0, $head_length);

                // Merge head and tail as sub list and reverse
                $sub_list = array_merge($tail_list, $head_list);
                $rev_list = array_reverse($sub_list);

                // Get the reversed head and tail
                $tail_rev = array_slice($rev_list, 0, $tail_length);
                $head_rev = array_slice($rev_list, $tail_length);

                // Put back reversed head and tail
                array_splice($list, $list_pos, $tail_length, $tail_rev);
                array_splice($list, 0, $head_length, $head_rev);
            }

            // We need to wrap position if we are goung outside the list
            // length, then increase skip_size by 1
            $list_pos = (($list_pos + $length + $skip_size) % $list_len);
            $skip_size++;
        }

        return $list[0] * $list[1];
    }
}

?>
