<?php

class PartTwo extends Base {
    private $programs;
    private $faulty_children;

    function __construct($input) {
        $this->programs = $input;
        $this->faulty_children = array();
    }

    /**
     * findFaultyChildren
     *
     * Find the children where one ckild has a different weight
     *
     * @param string[] $programs The full programs array
     * @param string $parent The parent node to check weight and balance
     * @return int Weight of parent node
     */
    private function findFaultyChildren(array $programs, string $parent) : int {
        // Find the whole parent node
        $full_parent_arr = preg_grep('/^('.$parent.').*$/', $programs);
        $full_parent_value = array_values($full_parent_arr)[0];

        // Split parent node and get node weight
        $split_parent = explode(" -> ", $full_parent_value);
        preg_match('#\((.*?)\)#', $split_parent[0], $weight_arr);
        $weight = intval($weight_arr[1]);

        // Return weight if there are no children (node is leaf)
        if (count($split_parent) === 1) {
            return $weight;
        }

        // Split children into array
        $children = explode(", ", $split_parent[1]);
        $children_weights = array();

        // Recursive step; find weights for all children, put into array
        foreach ($children as $child) {
            $children_weights[$child] = intval($this->findFaultyChildren($programs, $child));
        }

        // Check if there are multiple children weights and we didn't save
        // children weights before (array empty), save this as our faulty part
        // since problem states that there can only be one faulty program
        if (count(array_unique($children_weights)) > 1 && empty($this->faulty_children)) {
            $this->faulty_children = $children_weights;
        }

        // Return node weight + sum of children weights
        return $weight + array_sum($children_weights);
    }

    /**
     * getRootNode
     *
     * Get the name of the root node in the tree
     *
     * @param string[] $programs The full programs array
     * @return string Name of the root node
     */
    private function getRootNode(array $programs) : string {
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

    public function solve() {
        // Fetch programs variable to save runtime
        $programs = $this->programs;

        // Get root node
        $root_node = $this->getRootNode($programs);

        // Create tree with weight recurively. Find the faulty children (array
        // of children where one have different weight) while we are creating
        // the tree
        $this->findFaultyChildren($programs, $root_node);

        // Fetch the faoulty children array to save runtime
        $faulty_children = $this->faulty_children;

        // Initiate array for flipping
        $weight_for_children = array();

        // We need to do an array_flip, but since that removes duplicate keys
        // we do it manually, where the values are arrays and duplicate keys
        // end up in the same array
        foreach ($faulty_children as $child => $weight) {
            if (empty($weight_for_children[$weight])) {
                $weight_for_children[$weight] = array($child);
            } else {
                $weight_for_children[$weight][] = $child;
            }
        }

        $faulty_child = "";

        // Get the faulty child, the weight for the faulty child (calculated
        // during recursion) and the weight of the correct children (also
        // calculated)
        foreach ($weight_for_children as $key => $children) {
            if (count($children) === 1) {
                $faulty_child = $children[0];
                $faulty_child_weight = $key;
            } else {
                $correct_children_weight = $key;
            }
        }

        // // Calculate how much the faulty child differs
        $weight_diff = $faulty_child_weight - $correct_children_weight;

        // Get the actual weight of the faulty child
        $faulty_child_arr = preg_grep('/^('.$faulty_child.').*$/', $programs);
        $faulty_child_value = array_values($faulty_child_arr)[0];
        $split_faulty_child = explode(" -> ", $faulty_child_value);
        preg_match('#\((.*?)\)#', $split_faulty_child[0], $faulty_child_weight_arr);
        $faulty_child_actual_weight = intval($faulty_child_weight_arr[1]);

        // Return the correct weight for the faulty child
        return $faulty_child_actual_weight - $weight_diff;
    }
}

?>
