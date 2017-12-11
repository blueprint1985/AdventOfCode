<?php

/**
 * Class for problem part two
 *
 * @author Martin Björling <martinbjorling@gmail.com>
 * @license MIT
 * @copyright Martin Björling 2015 - 2017
 */
class PartTwo extends Base {
    private $lengths;
    private $list_len;
    private $list_max;

    function __construct($input) {
        $this->lengths = $input;
    }

    /**
     * runList
     *
     * Run a list and make knot hash
     *
     * @param int $skip_size The initial skip size
     * @param int $list_pos The initial position in the list
     * @param int[] $list The list being reordered
     * @param int[] $lengths The lengths for each reordering
     * @return mixed[] Array containing changed $skip_size, $list_pos and $list
     */
    private function runList(int $skip_size, int $list_pos, array $list, array $lengths) : array {
        // Go through each length
        foreach ($lengths as $i => $length) {
            // If length is 1, we don't need to do anything, just increase
            // position and skip size
            if ($length === 1) {
                // We need to wrap position if we are going outside the list
                // length, then increase skip_size by 1
                $list_pos = (($list_pos + $length + $skip_size) % $this->list_len);
                $skip_size++;
                continue;
            }

            // If the sub list we are looking for ends before the end of the
            // list (not wrapping around) we can just get the correct slice
            // and reverse it. Otherwise we need to get the tail and head of
            // the list as the sub list.
            if ($list_pos + $length <= $this->list_max) {
                // Get sub list, reverse it and put it back.
                $sub_list = array_slice($list, $list_pos, $length);
                $rev_list = array_reverse($sub_list);
                array_splice($list, $list_pos, $length, $rev_list);
            } else {
                // Get the tail and head lengths
                $tail_length = $this->list_len - $list_pos;
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
            $list_pos = (($list_pos + $length + $skip_size) % $this->list_len);
            $skip_size++;
        }

        // Return all that we need for next run
        return array($skip_size, $list_pos, $list);
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
        // Also convert to ASCII and add suffix
        $lengths = ($this->lengths === "") ?
            array() :
            array_map("ord", str_split($this->lengths));

        $additions = array(17, 31, 73, 47, 23);
        $lengths = array_merge($lengths, $additions);

        // Initiate variables
        $list = range(0, 255);
        //$list = range(0, 4); // For testing only!
        $skip_size = 0;
        $list_pos = 0;
        $this->list_len = count($list);
        $this->list_max = $this->list_len - 1;

        // Run the list 64 times
        for ($i=0; $i < 64; $i++) { 
            // Update necessary variables each run
            list($skip_size, $list_pos, $list) = $this->runList($skip_size, $list_pos, $list, $lengths);
        }

        // Create chunks that are 16 elements long
        $chunks = array_chunk($list, 16);

        // Go through each chunk
        foreach ($chunks as &$chunk) {
            // Bitwise xor each element in chunk
            $xor_val = array_reduce($chunk, function(int $carry, int $element) : int {
                return $carry ^ $element;
            }, 0);

            // Convert to hex
            $hex_val = dechex($xor_val);

            // Add leading 0 if answer is one char long, then assign
            $chunk = (strlen($hex_val) === 1) ? "0".$hex_val : $hex_val;
        }

        return strval(implode("", $chunks));
    }
}

?>
