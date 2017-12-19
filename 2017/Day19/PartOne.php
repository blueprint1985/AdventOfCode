<?php

/**
 * Class for problem part one
 *
 * @author Martin Björling <martinbjorling@gmail.com>
 * @license MIT
 * @copyright Martin Björling 2015 - 2017
 */
class PartOne extends Base {
    private $diagram;

    function __construct($input) {
        $this->diagram = $input;
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
        $diagram = array_map('str_split', $this->diagram);

        // Initiate variables
        $x = array_search("|", $diagram[0]);
        $y = 0;
        $dir = "d";
        $fin = false;
        $str = "";
        $height = count($diagram);
        $width = count($diagram[0]);

        // Loop until we find the end
        while (!$fin) {
            // Get next coordinate
            switch ($dir) {
                case 'd':
                    $y++;
                    break;

                case 'r':
                    $x++;
                    break;

                case 'u':
                    $y--;
                    break;

                case 'l':
                    $x--;
                    break;
                
                default:
                    # code...
                    break;
            }

            
            if ($diagram[$y][$x] === '+' && ($dir === 'd' || $dir === 'u')) {
                // We are turning left or right, change direction
                $dir = ($diagram[$y][$x-1] === ' ') ? 'r' : 'l';
            } else if ($diagram[$y][$x] === '+' && ($dir === 'r' || $dir === 'l')) {
                // We are turning up or down, change direction
                $dir = ($diagram[$y-1][$x] === ' ') ? 'd' : 'u';
            } else if (preg_match('/^[A-Z]$/i', $diagram[$y][$x])) {
                // We are adding letter
                $str .= $diagram[$y][$x];
            } else if ($diagram[$y][$x] === ' ' || $x < 0 || $x >= $width ||$y < 0 || $y >= $height) {
                // We are walking on empty coordinate or outside diagram,
                // finished
                $fin = true;
            }
        }

        return strval($str);
    }
}

?>
