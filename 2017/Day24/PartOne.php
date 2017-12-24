<?php

/**
 * Class for problem part one
 *
 * @author Martin Björling <martinbjorling@gmail.com>
 * @license MIT
 * @copyright Martin Björling 2015 - 2017
 */
class PartOne extends Base {
    private $components;
    private $max_strength;

    function __construct($input) {
        $this->components = $input;
        $this->max_strength = 0;
    }

    /**
     * buildBridges
     *
     * Builds the bridge recursively
     *
     * @param int $initValue The value to connect next bridge component
     * @param array[] $components All remaining bridge components
     * @param int $currStrength Strength of current bridge
     * @return void
     */
    private function buildBridges(int $initValue, array $components, int $currStrength) : void {
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
            // Get strength for current and check if it's larger than max
            $this_strength = $currStrength + array_sum($comp);
            $this->max_strength = max($this->max_strength, $this_strength);

            // Remove this component before recursive step
            $diff = $components;
            $throwaway = array_splice($diff, $comp_index, 1);

            // Get the init value for next recursion
            $init_value_key = abs(array_search($initValue, $comp) - 1);
            $newInit = $comp[$init_value_key];

            // Recursive step
            $this->buildBridges($newInit, $diff, $this_strength);
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

        // Get max strength recursively
        $this->buildBridges(0, $components, $this->max_strength);

        return strval($this->max_strength);
    }
}

?>
