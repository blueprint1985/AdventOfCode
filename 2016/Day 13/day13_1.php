<?php

function buildRoom($width, $height, $fav) {
    $row = array();

    for ($x=0; $x < $width+1; $x++) { 
        $col = array();

        for ($y=0; $y < $height+1; $y++) { 
            $dec_val = $x*$x + 3*$x + 2*$x*$y + $y + $y*$y;
            $dec_val += intval($fav);
            $bin_val = decbin($dec_val);
            $bin_str = strval($bin_val);
            $to_save = array_count_values(str_split($bin_str))["1"];
            $col[] = ($to_save % 2) ? "#" : ".";
        }

        $row[] = $col;
    }

    return $row;
}

function testPos($position, $room, $queue, $reachables, $goal, $dims) {
    if ($position[0] === $goal[0] && $position[1] === $goal[1]) {
        return array("found_target", $position[2]);
    }

    $curr_x = $position[0];
    $curr_y = $position[1];
    $all_to_test = array();
    $all_to_test[] = array($curr_x + 1, $curr_y);
    $all_to_test[] = array($curr_x - 1, $curr_y);
    $all_to_test[] = array($curr_x, $curr_y + 1);
    $all_to_test[] = array($curr_x, $curr_y - 1);
    $return_queue = array();
    $return_reachables = array();

    foreach ($all_to_test as $testing) {
        if ($testing[0] < 0 || $testing[1] < 0 || $testing[0] > $dims[0] || $testing[1] > $dims[1]) {
            continue;
        }

        if ($room[$testing[0]][$testing[1]] === "#") {
            continue;
        }

        $in_queue = false;
        foreach ($queue as $pos_in_queue) {
            if ($pos_in_queue[0] === $testing[0] && $pos_in_queue[1] === $testing[1]) {
                $in_queue = true;
                break;
            }
        }

        $in_reachables = false;
        foreach ($reachables as $pos_in_reachables) {
            if ($pos_in_reachables[0] === $testing[0] && $pos_in_reachables[1] === $testing[1]) {
                $in_reachables = true;
                break;
            }
        }

        if ($in_queue || $in_reachables) {
            continue;
        }

        $return_queue[] = array($testing[0], $testing[1], $position[2]+1);
        $return_reachables[] = array($testing[0], $testing[1]);
    }

    if (count($return_queue) === 0) {
        return array("no_possibilities");
    }

    return array("has_additions", $return_queue, $return_reachables);
}

$myfile = fopen("day13_input.txt", "r") or die("Unable to open file!");
$fav_num = trim(fgets($myfile));
fclose($myfile);

$goal = array(31,39);
$dims = array($goal[0]+2, $goal[1]+2);
$room = buildRoom($dims[0], $dims[1], $fav_num);
$queue = array(array(1, 1, 0));
$reachables = array();

while (count($queue) > 0) {
    $to_test = array_shift($queue);
    $test_pos = testPos($to_test, $room, $queue, $reachables, $goal, $dims);

    if ($test_pos[0] === "found_target") {
        $num_of_steps = $test_pos[1];
    }

    if ($test_pos[0] === "has_additions") {
        $queue = array_merge($queue, $test_pos[1]);
        $reachables = array_merge($reachables, $test_pos[2]);
    }
}

echo($num_of_steps);

?>
