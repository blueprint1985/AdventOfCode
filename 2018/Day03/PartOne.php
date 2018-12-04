<?php

/**
 * Class for problem part one
 *
 * @author Martin Björling <martinbjorling@gmail.com>
 * @license MIT
 * @copyright Martin Björling 2015 - 2018
 */
class PartOne extends Base {
    private $claims;

    function __construct($input) {
        $this->claims = $input;
    }

    /**
     * solve
     *
     * Solves the problem based on the input
     *
     * @return string The solution for the problem
     */
    public function solve() : string {
        $claims = $this->claims;

        // Initiate variables
        $x_max = 0;
        $y_max = 0;

        // Loop though each row in the claims
        foreach ($claims as $index => $claim) {
            // Clean up the row
            $cleaned = explode(" @ ", $claim);
            $split = explode(": ", $cleaned[1]);
            list($x, $y) = explode(",", $split[0]);
            list($width, $height) = explode("x", $split[1]);

            // Check if max is larger than before
            $x_max = max($x_max, (int) $x + (int) $width);
            $y_max = max($y_max, (int) $y + (int) $height);

            // Set claim
            $claims[$index] = [
                'id' => (int) substr($cleaned[0], 1),
                'x' => (int) $x,
                'y' => (int) $y,
                'width' => (int) $width,
                'height' => (int) $height
            ];
        }

        // Create the fabric as 2D-array
        $fabric = array_fill(0, $x_max, array_fill(0, $y_max, 0));
        $has_multiple = 0;

        // Loop though each row in the claims
        foreach ($claims as $claim) {
            // Loop through each x-/y-value of the claim
            for ($i = $claim['x']; $i < ($claim['x'] + $claim['width']); $i++) {
                for ($j= $claim['y']; $j < ($claim['y'] + $claim['height']); $j++) {
                    // If it's already claimed exactly once and we claim it again, it has mutiple claims
                    if ($fabric[$i][$j] === 1) {
                        $has_multiple++;
                    }

                    // Claim
                    $fabric[$i][$j]++;
                }
            }
        }

        return strval($has_multiple);
    }
}

?>
