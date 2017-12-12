<?php

/**
 * Class for problem part two
 *
 * @author Martin Björling <martinbjorling@gmail.com>
 * @license MIT
 * @copyright Martin Björling 2015 - 2017
 */
class PartTwo extends Base {
    private $programs;

    function __construct($input) {
        $this->programs = $input;
    }

    /**
     * countPrograms
     *
     * Recursively get all visited programs starting from a root program
     *
     * @param string[] $programs The full programs array
     * @param string $parent The current root program node to check
     * @param string[] $visited All visited program nodes
     * @return string[] All visited program nodes including new ones
     */
    private function countPrograms(array $programs, string $program, array $visited) : array {
        // Store program as visited so we don't visit it several times, because
        // that would give infinite loop
        $visited[] = $program;

        // Get all childen as array
        $children = explode(', ', $programs[$program]);

        // Go through each children
        foreach ($children as $child) {
            // Only if we didn't already visit the child
            if (!in_array($child, $visited)) {
                // Get visited for child but only store diff in visited for
                // saving memory
                $vis_temp = $this->countPrograms($programs, $child, $visited);
                $visited = array_merge($visited, array_diff($vis_temp, $visited));
            }
        }

        // Return all visited
        return $visited;
    }

    /**
     * solve
     *
     * Solves the problem based on the input
     *
     * @return string The solution for the problem
     */
    public function solve() : string {
        // Fetch programs variable to save runtime and make each program key,
        // and children value. This works since the programs array is already
        // sorted numerically with programs as "keys" starting with 0 and
        // increasing by 1.
        $programs = array_map(function($program) {
            list($parent, $children) = explode(' <-> ', $program);
            return $children;
        }, $this->programs);

        // Initiate current coordinate
        $groups = 0;

        // Loop until programs array is empty
        while (count($programs) > 0) {
            $visited = array();

            // Start with the lowest program
            $start = strval(min(array_keys($programs)));
            $visited = $this->countPrograms($programs, $start, $visited);

            $groups++;

            // Remove all the visited for this loop round from programs array
            foreach ($visited as $pos) {
                unset($programs[intval($pos)]);
            }
        }

        return strval($groups);
    }
}

?>
