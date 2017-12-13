<?php

/**
 * Class for problem part two
 *
 * @author Martin Björling <martinbjorling@gmail.com>
 * @license MIT
 * @copyright Martin Björling 2015 - 2017
 */
class PartTwo extends Base {
    private $layers;

    function __construct($input) {
        $this->layers = $input;
    }

    /**
     * solve
     *
     * Solves the problem based on the input
     *
     * @return string The solution for the problem
     */
    public function solve() : string {
        // Fetch layers variable to save runtime
        // Make better array for each layer, a layer will look loke this:
        // 0 => ["range" => 3, "roundtime" => 4]
        // Roundtime is the time for the scanner to go from position 0 to the
        // end and then back to position 0 again for each layer
        $layers = array();
        foreach ($this->layers as $layer) {
            list($layer, $range) = explode(": ", $layer);
            $roundtime = (intval($range) - 1) * 2;
            $layers[intval($layer)] = array("range" => intval($range), "roundtime" => $roundtime);
        }

        // Initiate variables
        $last_layer_index = max(array_keys($layers));
        $caught = true;
        $start_time = -1;

        // Loop while we got caught stepping through the firewall
        while ($caught) {
            // Reset caught and increase start time
            $caught = false;
            $start_time++;

            // Step through firewall
            for ($i=0; $i < $last_layer_index + 1; $i++) {
                // There is no layer this step
                if (empty($layers[$i])) {
                    continue;
                }

                // Layer i scanner position at step i with start time added
                $pos_i = ($i + $start_time) % $layers[$i]["roundtime"];

                // If layer i scanner is at position 0 at step i, we are caught
                // and there is no need to continue stepping through the
                // firewall
                if ($pos_i === 0) {
                    $caught = true;
                    break;
                }
            }
        }

        return strval($start_time);
    }
}

?>
