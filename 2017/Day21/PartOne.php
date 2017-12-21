<?php

/**
 * Class for problem part one
 *
 * @author Martin Björling <martinbjorling@gmail.com>
 * @license MIT
 * @copyright Martin Björling 2015 - 2017
 */
class PartOne extends Base {
    private $rules;

    function __construct($input) {
        $this->rules = $input;
    }

    /**
     * rotateSquare
     *
     * Rotates a square 90 degrees clockwise
     *
     * @param string $square The square to be rotated
     * @return string The square rotated 90 deg clockwise
     */
    private function rotateSquare(string $square) : string {
        // Split square into array
        $square_array = explode("/", $square);
        $size = count($square_array);

        // Split each row into array
        foreach ($square_array as &$row) {
            $row = str_split($row);
        }

        // Initiate new square
        $new_square = array();

        // Make actual rotate
        for ($i = 0; $i < $size; $i++) {
            for ($j = 0; $j < $size; $j++) {
                $new_square[$size - $i - 1][$j] = $square_array[$size - $j - 1][$i];
            }
        }

        // Put each row back as string
        foreach ($new_square as &$row) {
            $row = implode("", $row);
        }

        // Put entire square back as string
        return implode("/", $new_square);
    }

    /**
     * transformSquare
     *
     * Transform (flips and/or rotates) a square
     *
     * @param string $square The square to be transformed
     * @param string $type Which transformation to make
     * @return string The transformed square
     */
    private function transformSquare(string $square, string $type) : string {
        switch ($type) {
            case 'flipV':
                // We are performing vertical flip
                $sq_arr = explode("/", $square);
                $square = implode("/", array_reverse($sq_arr));
                break;

            case 'flipH':
                // We are performing horizontal flip
                $sq_arr = explode("/", $square);
                foreach ($sq_arr as &$elem) {
                    $elem = strrev($elem);
                }
                $square = implode("/", $sq_arr);
                break;

            case 'rotate090':
                // We are performing 90 deg rotate
                $square = $this->rotateSquare($square);
                break;

            case 'rotate180':
                // We are performing 180 deg rotate
                $square = $this->rotateSquare($square);
                $square = $this->rotateSquare($square);
                break;

            case 'rotate270':
                // We are performing 270 deg rotate
                $square = $this->rotateSquare($square);
                $square = $this->rotateSquare($square);
                $square = $this->rotateSquare($square);
                break;

            case 'flipVrotate090':
                // We are performing vertical flip then 90 deg rotate
                $sq_arr = explode("/", $square);
                $square = implode("/", array_reverse($sq_arr));
                $square = $this->rotateSquare($square);
                break;

            case 'flipVrotate270':
                // We are performing vertical flip then 270 deg rotate
                $sq_arr = explode("/", $square);
                $square = implode("/", array_reverse($sq_arr));
                $square = $this->rotateSquare($square);
                $square = $this->rotateSquare($square);
                $square = $this->rotateSquare($square);
                break;
            
            default:
                break;
        }

        return $square;
    }

    /**
     * splitGrid
     *
     * Splits grid into squares
     *
     * @param string[] $grid_rows The grid to be split divided into rows
     * @param string $row_squares How many squares fits into one row in the grid
     * @param string $square_size Width/height of a square 
     * @return string[] Array of all squares in the grid
     */
    private function splitGrid(array $grid_rows, int $row_squares, int $square_size) : array {
        // Get each "square row", i.e. row of sub squares and initiate array of
        // sub squares
        $square_rows = array_chunk($grid_rows, $square_size);
        $squares = array();

        // Lopop square rows
        foreach ($square_rows as $sq_row) {

            // Split each row in the square rows into square size
            $sq_row = array_map(function($row) use ($square_size) {
                return str_split($row, $square_size);
            }, $sq_row);

            
            // Once per each square in a row square
            for ($i=0; $i < $row_squares; $i++) { 
                $square = array();

                // Add all i elements to square
                foreach ($sq_row as $row) {
                    $square[] = $row[$i];
                }

                // Implode square and put it in squares array
                $squares[] = implode("/", $square);
            }
        }

        return $squares;
    }

    /**
     * applyRules
     *
     * Applies rules on each square in the grid
     *
     * @param string[] $squares All the squares in the grid
     * @param string[] $rules Array with all rules
     * @return string[] Array of all squares with rules applied
     */
    private function applyRules(array $squares, array $rules) : array {
        // Test each square
        foreach ($squares as &$square) {
            // Check if square exists in rules array and if it does, replace
            // the old square in squares array, continue to next square
            if (array_key_exists($square, $rules)) {
                $square = $rules[$square];
                continue;
            }

            // All transformations we need to test
            $transformations = array("flipH", "flipV", "rotate090", "rotate180", "rotate270", "flipVrotate090", "flipVrotate270");

            // Go trhough the transformations
            foreach ($transformations as $trans) {
                // Test the square with current transformation
                $test_square = $this->transformSquare($square, $trans);

                // Check if transformed square exits in rules array and if it
                // does replace the old square in squares array, continue to
                // next square, no need to test the rest of the transformations
                if (array_key_exists($test_square, $rules)) {
                    $square = $rules[$test_square];
                    break;
                }
            }
        }

        return $squares;
    }

    /**
     * mergeGrid
     *
     * Takes all squares in the grid and put them back together to form the
     * grid again
     *
     * @param string[] $squares All the squares in the grid
     * @return string The grid put toghether
     */
    private function mergeGrid(array $squares) : string{
        // Get the amount of squares in each "row of squares", divide squares
        // array into chunks of that amount, one chunk is one square row
        $row_squares = sqrt(count($squares));
        $rows = array_chunk($squares, $row_squares);

        // Initiate array of rows in full grid
        $grid_rows = array();

        // Loop square rows
        foreach ($rows as $row) {
            $grid_row = array();

            // Loop each square
            foreach ($row as $square) {
                // Divide the square into it's rows
                $square = explode("/", $square);

                // Go through the square rows
                foreach ($square as $i => $sq_row) {
                    // Create the grid row if we don't have it
                    if (empty($grid_row[$i])) {
                        $grid_row[$i] = "";
                    }

                    // Add the square row to the grid row
                    $grid_row[$i] .= $sq_row;
                }
                
            }

            // Add each grid row to full array of grid rows
            foreach ($grid_row as $gr_row) {
                $grid_rows[] = $gr_row;
            }
        }

        // Put entire grid back together
        return implode("/", $grid_rows);
    }

    /**
     * solve
     *
     * Solves the problem based on the input
     *
     * @return string The solution for the problem
     */
    public function solve() : string {
        // Fetch rules variable to save runtime and put it to new array where
        // key is compare value and value is resulting value
        $rules = array();
        foreach ($this->rules as $rule) {
            $rule_arr = explode(' => ', $rule);
            $rules[$rule_arr[0]] = $rule_arr[1];
        }

        // Initiate grid and iteration amount
        $grid = ".#./..#/###";
        $iteration_amount = 5;
        //$iteration_amount = 2; // for testing only

        for ($i=0; $i < $iteration_amount; $i++) {
            // Variables for each loop round
            $grid_rows = explode("/", $grid);
            $grid_side = count($grid_rows);
            $row_squares = ($grid_side % 2 === 0) ? $grid_side / 2 : $grid_side / 3;
            $square_size = ($grid_side % 2 === 0) ? 2 : 3;

            // Divide into squares if we are above first iteration
            if ($row_squares > 1) {
                $grid_squares = $this->splitGrid($grid_rows, $row_squares, $square_size);
            } else {
                $grid_squares = array($grid);
            }

            // Apply rules to squares
            $grid_squares = $this->applyRules($grid_squares, $rules);

            // Put squares back together
            $grid = $this->mergeGrid($grid_squares);
        }

        // Count nomber if # and return
        return strval(substr_count($grid, "#"));
    }
}

?>
