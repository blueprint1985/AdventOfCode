<?php

/**
 * Class for problem part two
 *
 * @author Martin Björling <martinbjorling@gmail.com>
 * @license MIT
 * @copyright Martin Björling 2015 - 2018
 */
class PartTwo extends Base {
    private $timestamps;

    function __construct($input) {
        $this->timestamps = $input;
    }

    /**
     * solve
     *
     * Solves the problem based on the input
     *
     * @return string The solution for the problem
     */
    public function solve() : string {
        // Fetch timestamps variable to save runtime and sort
        $timestamps = $this->timestamps;
        sort($timestamps, SORT_STRING);

        // Initiate variables
        $guards = [];
        $times_arr = [];
        $current_guard = 0;
        $sleep_time = 0;
        $max_guard = 0;
        $max_guard_sleep = 0;
        $max_guard_minute = 0;

        // Loop though each row in the timestamps
        foreach ($timestamps as $timestamp) {
            // Get time and event
            list($time, $event) = explode("] ", $timestamp);
            $time = substr($time, 1);

            if ($event === "falls asleep") {
                // Set time when guard falls asleep
                $sleep_time = (int) substr($time, -2);
            } else if ($event === "wakes up") {
                $wake_time = (int) substr($time, -2);
                // Loop though sleeping minutes and add 1 for each minute for current guard
                for ($i = $sleep_time; $i < (int) substr($time, -2); $i++) { 
                    $guards[$current_guard][$i]++;
                }
            } else {
                // Change guard
                $current_guard = (int) substr(explode(" ", $event)[1], 1);

                // If guard not in guards array, add with minutes
                if (!array_key_exists($current_guard, $guards)) {
                    $guards[$current_guard] = array_fill(0, 60, 0);
                }
            }
        }

        // Loop though guards array to get guard with max minute
        foreach ($guards as $guard => $sleep) {
            if (max($sleep) > $max_guard_sleep) {
                $max_guard_minute = array_keys($sleep, max($sleep))[0];
                $max_guard_sleep = max($sleep);
                $max_guard = (int) $guard;
            }
        }

        return strval($max_guard * $max_guard_minute);
    }
}

?>
