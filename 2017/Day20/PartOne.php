<?php

/**
 * Class for problem part one
 *
 * @author Martin Björling <martinbjorling@gmail.com>
 * @license MIT
 * @copyright Martin Björling 2015 - 2017
 */
class PartOne extends Base {
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
     * filterByField
     *
     * Get all particles that has minimum value of something
     *
     * @param array[] $to_filter The particles to filter
     * @param string $filter_by What attribute to filter by
     * @return array[] The pythagorean distance
     */
    private function filterByField(array $to_filter, string $filter_by) : array {
        // Get all values that are $to_clear[i][$clear_by]
        $mapped = array_map(function(array $particle) use ($filter_by) : int {
            return $particle[$filter_by];
        }, $to_filter);

        // Get minimum value of mapped
        $min_val = min($mapped);

        // Remove all that doesn't have the minimum value in $filter_by attr
        $min_val_mapped = array_filter($to_filter, function(array $particle) use ($filter_by, $min_val) : bool {
            return ($particle[$filter_by] === $min_val);
        });

        return $min_val_mapped;
    }

    /**
     * solve
     *
     * Solves the problem based on the input
     *
     * @return string The solution for the problem
     */
    public function solve() : string {
        // Fetch buffer variable to save runtime and parse it
        $buffer = $this->parseBuffer($this->buffer);

        // The algorithm tells us that the particle with the least acceleration
        // is the one we are looking for. If several particles have the same
        // least, we will look at least velocity. If we still have several
        // particles, we will look at shortest distance to center.

        // Get particles with least distance
        $min_acc_particles = $this->filterByField($buffer, "acc");

        // We only have one particle, return that
        if (count($min_acc_particles) === 1) {
            return strval(array_keys($min_acc_particles)[0]);
        }

        // If not only one particle
        $all_leaving = false;

        // Loop until all remaining particles are "leaving" center
        while (!$all_leaving) {
            $all_leaving = true;

            // Loop each particle
            foreach ($min_acc_particles as &$particle) {
                // Get distance before change
                $dist_before = $particle["pos"];

                // Calc new velocity and position
                foreach ($particle["a"] as $axis => $acc) {
                    $particle["v"][$axis] += $acc;
                    $particle["p"][$axis] += $particle["v"][$axis];
                }

                // Get new relative velocity and position
                $particle["pos"] = $this->getDist($particle["p"]);
                $particle["vel"] = $this->getDist($particle["v"]);

                // Check if particle is leaving center, if not, all particles
                // Are not leaving
                if ($dist_before > $particle["pos"]) {
                    $all_leaving = false;
                }
            }
        }

        // Get particles with least velocity
        $min_vel_particles = $this->filterByField($min_acc_particles, "vel");

        // We only have one particle, return that
        if (count($min_acc_particles) === 1) {
            return strval(array_keys($min_vel_particles)[0]);
        }

        // Get particles closest to center
        $min_pos_particles = $this->filterByField($min_vel_particles, "pos");

        return strval(array_keys($min_pos_particles)[0]);
    }
}

?>
