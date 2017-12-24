<?php

/**
 * Class for problem part two
 *
 * @author Martin Björling <martinbjorling@gmail.com>
 * @license MIT
 * @copyright Martin Björling 2015 - 2017
 */
class PartTwo extends Base {
    private $components;
    private $bridges;

    function __construct($input) {
        $this->components = $input;
        $this->bridges = array();
    }

    /**
     * buildBridges
     *
     * Builds the bridge recursively
     *
     * @param int $initValue The value to connect next bridge component
     * @param array[] $components All remaining bridge components
     * @param string $bridge The current bridge we are building recursively
     * @return void
     */
    private function buildBridges(int $initValue, array $components, string $bridge) : void {
        // Find all bridge components that has initial value
        $has_init = array_filter($components, function($component) use ($initValue) {
            return in_array($initValue, $component);
        });

        // If none found, return
        if (count($has_init) === 0) {
            return;
        }

        // Go through all found bridge components
        foreach ($has_init as $comp_index => $comp) {
            // Create a new bridge and add to list of bridges
            $new_bridge = $bridge."/".implode("/", $comp);
            $this->bridges[] = $new_bridge;

            // Remove this component before recursive step
            $diff = $components;
            $throwaway = array_splice($diff, $comp_index, 1);

            // Get the init value for next recursion
            $init_value_key = abs(array_search($initValue, $comp) - 1);
            $newInit = $comp[$init_value_key];

            // Recursive step
            $this->buildBridges($newInit, $diff, $new_bridge);
        }

        return;
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
        $components = array_map(function(string $component) : array {
            return array_map("intval", explode("/", $component));
        }, $this->components);

        // Ran out of memory (started with 128M)
        ini_set('memory_limit','1024M');

        // Build all bridges and put into array
        $this->buildBridges(0, $components, "0");

        // Initiate max_length and max_strength
        $max_length = 0;
        $max_strength = 0;

        // Loop all bridges
        foreach ($this->bridges as $key => $bridge) {
            $arr = explode("/", $bridge);

            // If current bridge same or longer than longest
            if (count($arr) >= $max_length) {
                $max_length = count($arr);

                // If current bridge stronger than strongest
                if (array_sum($arr) > $max_strength) {
                    $max_strength = array_sum($arr);
                }
            }
        }

        return strval($max_strength);
    }
}

?>
