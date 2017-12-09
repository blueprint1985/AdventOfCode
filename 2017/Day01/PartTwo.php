<?php

class PartTwo extends Base {
    private $list;

    function __construct($input) {
        $this->list = str_split($input);
    }

    public function solve() {
        // Fetch list variable to save runtime
        $list = $this->list;

        $sum = 0;
        $i = 0;
        $list_len = count($list);

        // Loop thouch all elements
        while ($i < $list_len) {
            // Compare the current element with one halfway around
            // If they are the same, add to sum
            if ($list[$i] === $list[($i+($list_len/2))%$list_len]) {
                $sum += intval($list[$i], 10);
            }

            $i++;
        }

        return $sum;
    }
}

?>
