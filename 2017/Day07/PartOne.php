<?php

class PartOne extends Base {
    private $programs;

    function __construct($input) {
        $this->programs = $input;
    }

    public function solve() {
        // Fetch programs variable to save runtime
        $programs = $this->programs;

        // Initiate arrays
        $nodes = array();
        $children = array();

        // Loop all programs
        foreach ($programs as $program) {
            // Split program into node and children part, remove weight for now
            $split_prg = explode(" -> ", $program);
            $node = $split_prg[0];
            $split_node = explode(" ", $node);

            // If program array has two elements, it's a node, otherwise it's
            // only a child (leaf)
            if (count($split_prg) > 1) {
                // Add node to nodes array
                $nodes[] = $split_node[0];

                // Split children
                $split_leaves = explode(", ", $split_prg[1]);
                
                // Add children to children array
                foreach ($split_leaves as $leaf) {
                    $children[] = $leaf;
                }
            } else {
                $children[] = $split_node[0];
            }
        }

        // Logic tells us that the only node that is not also a child is our
        // root node
        return array_values(array_diff($nodes, $children))[0];
    }
}

?>
