<?php

class PartOne extends Base {
    private $square;

    function __construct($input) {
        $this->square = $input;
    }

    public function solve() {
        // Convert square to int
        $square = intval($this->square);

        // Algoritm to calculate the width and height of the grid that has the square
        // in the edge of the grid. Since this type of grid can only have an odd 
        // number as the length of the side, we need to add 1 to the size if the result
        // is even. We also need to know the maximum number for the calculated grid
        // size. Last we calculate the distance from an grid corner to a midpoint on
        // the edge ow the grid which is also the same as the distance from an edge
        // midpoint to the center.
        $grid_size = ceil(sqrt($square));
        $grid_size = ($grid_size % 2 === 0) ? $grid_size + 1 : $grid_size;
        $grid_max = $grid_size ** 2;
        $grid_level = floor($grid_size / 2);

        // We now need to calculate the midpoints of each side. We do this, since the
        // midpoints have a straight path to grid 1. We know that the maximum number
        // possible will always be in the lower right corner and numbers lower
        // clockwise around the edge. Mid bottom is halfway to the next corner, which
        // means half the grid_size away from maximum, and then the midpoints are
        // maximum away from each other with 1 removed.
        $grid_mid_bottom = $grid_max - $grid_level;
        $grid_mid_left = $grid_mid_bottom - ($grid_size - 1);
        $grid_mid_top = $grid_mid_left - ($grid_size - 1);
        $grid_mid_right = $grid_mid_top - ($grid_size - 1);

        // Calculate the distance from the square to each endpoint. Use absolute value
        // so that all distances are positive.
        $mid_bottom_dist = abs($square - $grid_mid_bottom);
        $mid_left_dist = abs($square - $grid_mid_left);
        $mid_top_dist = abs($square - $grid_mid_top);
        $mid_right_dist = abs($square - $grid_mid_right);

        // When we know the midpoints we need to calculate shortest distance from a
        // midpoint to our value. After that we add the distance from that midpoint to
        // the center. That gives is the Manhattan distance.
        $min_midpoint_dist = min($mid_bottom_dist, $mid_left_dist, $mid_top_dist, $mid_right_dist);
        $manhattan_dist = $min_midpoint_dist + $grid_level;

        return $manhattan_dist;
    }
}

?>
