<?php

class PartTwo extends Base {
    private $passwords;

    function __construct($input) {
        $this->passwords = $input;
    }

    /**
     * isAnagram
     * 
     * Compare two strings and check if they are anagrams
     *
     * @param string $str_one The first string
     * @param string $str_two The second string
     * @return bool true if strings are anagrams, false otherwise
     */
    private function isAnagram(string $str_one, string $str_two) {
        $str_lengths = strlen($str_one);

        // Two words must be of same length to be anagrams
        if ($str_lengths !== strlen($str_two)) {
            return false;
        }

        // Loop each character in the first word to check if it appears in the
        // second word
        for ($i=0; $i < $str_lengths; $i++) {
            $char = $str_one[$i];
            $str_two_pos = strpos($str_two, $char);

            // Character does not appear in the second word
            if ($str_two_pos === false) {
                return false;
            }

            // Remove the character from the second word
            $str_two = substr_replace($str_two, "", $str_two_pos, 1);
        }

        return true;
    }

    /**
     * checkForAnagrams
     * 
     * Check if an array contains any anagrams.
     *
     * @param string[] $pass_split The array to check for anagrams
     * @return bool true if array contains anagrams, false otherwise
     */
    private function checkForAnagrams(array $pass_split) {
        $pass_length = count($pass_split);
        $pass_length_short = $pass_length - 1;

        // Outer loop loops entire pass except last element
        // Inner loop loops all elements after outer pass current index
        for ($i = 0; $i < $pass_length_short; $i++) {
            for ($j = $i + 1; $j < $pass_length; $j++) {
                // Return true as soon as we find any anagrams
                if ($this->isAnagram($pass_split[$i], $pass_split[$j])) {
                    return true;
                }
            }
        }

        return false;
    }

    public function solve() {
        // Fetch passwords variable to save runtime
        $passwords = $this->passwords;

        // Initiate correct
        $correct = 0;

        // Loop though each password
        foreach ($passwords as $pass) {
            // Convert the password to array and check for duplicates by flipping array
            // and since an array must have unique keys, if there are any duplicates,
            // the flipped array will be shorter
            $pass_split = explode(" ", $pass);
            if (count($pass_split) !== count(array_flip($pass_split))) {
                continue;
            }

            // If we didn't have any duplicates, check for anagrams
            if (!$this->checkForAnagrams($pass_split)) {
                $correct++;
            }
        }

        return $correct;
    }
}

?>
