<?php

/**
 * Class for problem part one
 *
 * @author Martin Björling <martinbjorling@gmail.com>
 * @license MIT
 * @copyright Martin Björling 2015 - 2018
 */
class PartOne extends Base {
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
        $minutes = array_fill(0, 60, 0);

        // Loop though each row in the timestamps
        foreach ($timestamps as $timestamp) {
            // Get time and event
            list($time, $event) = explode("] ", $timestamp);
            $time = substr($time, 1);

            if ($event === "falls asleep") {
                // Set time when guard falls asleep
                $sleep_time = (int) substr($time, -2);
            } else if ($event === "wakes up") {
                // Calculate sleeping length and add to current guard
                $guards[$current_guard] += (int) substr($time, -2) - $sleep_time;
            } else {
                // Change guard
                $current_guard = (int) substr(explode(" ", $event)[1], 1);

                // If guard not in guards array, add
                if (!array_key_exists($current_guard, $guards)) {
                    $guards[$current_guard] = 0;
                }
            }
        }

        // Get guard with max sleeping time
        $max_guard = array_keys($guards, max($guards))[0];

        // Loop though each row in the timestamps
        foreach ($timestamps as $timestamp) {
            // Get time and event
            list($time, $event) = explode("] ", $timestamp);
            $time = substr($time, 1);

            if ($event === "falls asleep" && $current_guard === $max_guard) {
                $sleep_time = (int) substr($time, -2);
            } else if ($event === "wakes up" && $current_guard === $max_guard) {
                // Loop though sleeping minutes and add 1 for each minute
                for ($i = $sleep_time; $i < (int) substr($time, -2); $i++) { 
                    $minutes[$i]++;
                }
            } else {
                // Change guard
                $current_guard = (int) substr(explode(" ", $event)[1], 1);
            }
        }

        // Get guard max sleeping minute
        $max_minute = array_keys($minutes, max($minutes))[0];

        return strval($max_guard * $max_minute);
    }
}

?>
