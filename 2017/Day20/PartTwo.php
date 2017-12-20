<?php

/**
 * Class for problem part two
 *
 * @author Martin Björling <martinbjorling@gmail.com>
 * @license MIT
 * @copyright Martin Björling 2015 - 2017
 */
class PartTwo extends Base {
    private $buffer;

    function __construct($input) {
        $this->buffer = $input;
    }

    /**
     * getDist
     *
     * Get pythagorean distance for a coordinate
     *
     * @param int[] $coord The coordinates
     * @return int The pythagorean distance
     */
    private function getDist(array $coord) : int {
        return sqrt(($coord[0] ** 2) + ($coord[1] ** 2) + ($coord[2] ** 2));
    }

    /**
     * parseBuffer
     *
     * Get pythagorean distance for a coordinate
     *
     * @param string[] $buffer The input bugger
     * @return array[] The pythagorean distance
     */
    private function parseBuffer(array $buffer) : array {
        // Go through buffer
        foreach ($buffer as &$particle) {
            // Get each attribute of the particle
            $part_arr = explode(", ", $particle);

            // Make int array of each attribute
            foreach ($part_arr as &$part) {
                $temp = explode(",", substr($part, 3, -1));
                $part = array_map('intval', $temp);
            }

            // Store each attribute in new array with keys, add extra needed
            $part_tmp = array("p" => $part_arr[0], "v" => $part_arr[1], "a" => $part_arr[2]);
            $part_tmp["pos"] = $this->getDist($part_tmp["p"]);
            $part_tmp["vel"] = $this->getDist($part_tmp["v"]);
            $part_tmp["acc"] = $this->getDist($part_tmp["a"]);

            // Set as particle
            $particle = $part_tmp;
        }

        return $buffer;
    }

    /**
     * checkIfCanStillCollide
     *
     * Find out if collisions are still possible in the buffer
     *
     * @param string[] $position_changes Position change for the last step for each particle
     * @return boolean If collisions are still possible or not
     */
    private function checkIfCanStillCollide(array $position_changes) : bool {
        // Get max value for loops
        $particle_amount = count($position_changes);

        // Loop each particle's position change, and then the following
        // particles' position change
        for ($i=0; $i < $particle_amount - 1; $i++) {
            for ($j=$i+1; $j < $particle_amount; $j++) {
                $outer = $position_changes[$i];
                $inner = $position_changes[$j];

                // Get distance between particles before and after the step
                $dist_before = $this->getDist(array(
                    $outer[0][0]-$inner[0][0],
                    $outer[0][1]-$inner[0][1],
                    $outer[0][2]-$inner[0][2]
                ));
                $dist_after = $this->getDist(array(
                    $outer[1][0]-$inner[1][0],
                    $outer[1][1]-$inner[1][1],
                    $outer[1][2]-$inner[1][2]
                ));

                // If distance is lower, collision can still happen (that means
                // they are moving towards each other)
                if ($dist_after < $dist_before) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * removeCollisions
     *
     * Remove all collided particles from buffer
     *
     * @param array[] $buffer Buffer after each step
     * @return array[] Buffer with removed collisions
     */
    private function removeCollisions(array $buffer) : array {
        // Get all particle positions as JSON
        $mapped = array_map(function(array $particle) : string {
            return json_encode($particle["p"]);
        }, $buffer);

        // Count amount of each particle position
        $map_values_counted = array_count_values($mapped);

        // Remove all particle positions that has only one particle
        $singles_removed = array_keys(array_filter($map_values_counted, function(string $amount) : bool {
            return ($amount > 1);
        }));

        // Go trough all particle positions with more than one particle and
        // remove those positions from buffer
        foreach ($singles_removed as $value) {
            $keys = array_keys($mapped, $value);

            foreach ($keys as $buffer_index) {
                unset($buffer[$buffer_index]);
            }
        }

        return $buffer;
    }

    /**
     * solve
     *
     * Solves the problem based on the input
     *
     * @return string The solution for the problem
     */
    public function solve() : string {
        // Fetch buffer variable to save runtime
        $buffer = $this->parseBuffer($this->buffer);

        // Particles can still collide
        $can_still_collide = true;

        while ($can_still_collide) {
            // Reset position changes array
            $pos_change = array();

            // Go through buffer
            foreach ($buffer as &$particle) {
                // Get position before change
                $pos_before = $particle["p"];

                // Calc new velocity and position
                foreach ($particle["a"] as $axis => $acc) {
                    $particle["v"][$axis] += $acc;
                    $particle["p"][$axis] += $particle["v"][$axis];
                }

                // Get new relative velocity and position
                $particle["pos"] = $this->getDist($particle["p"]);
                $particle["vel"] = $this->getDist($particle["v"]);

                // Add old and new position to position change array
                $pos_change[] = array($pos_before, $particle["p"]);
            }

            // Remove all any collisions
            $buffer = $this->removeCollisions($buffer);

            // Check if we can still collide
            $can_still_collide = (count($buffer) <= 1) ? false : $this->checkIfCanStillCollide($pos_change);
        }

        return strval(count($buffer));
    }
}

?>
