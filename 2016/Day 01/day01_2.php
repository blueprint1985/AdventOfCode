<?php

function turn($old_pos, $turn_instr) {
    if ($old_pos['face'] === "N") {
        $old_pos['face'] = $turn_instr === "R" ? "E" : "W";
        return $old_pos;
    }

    if ($old_pos['face'] === "S") {
        $old_pos['face'] = $turn_instr === "R" ? "W" : "E";
        return $old_pos;
    }

    if ($old_pos['face'] === "E") {
        $old_pos['face'] = $turn_instr === "R" ? "S" : "N";
        return $old_pos;
    }

    if ($old_pos['face'] === "W") {
        $old_pos['face'] = $turn_instr === "R" ? "N" : "S";
        return $old_pos;
    }
}

function calcAxis($face) {
    if ($face === "N" || $face === "S") {
        return 'y';
    } else {
        return 'x';
    }
}

function calcAdd($face) {
    if ($face === "N" || $face === "W") {
        return -1;
    } else {
        return 1;
    }
}

function walk($old_pos, $walk_dist) {
    for ($i=0; $i < $walk_dist; $i++) { 
        $old_pos[calcAxis($old_pos['face'])] += calcAdd($old_pos['face']);

        $curr_pos_str = strval($old_pos['x']).strval($old_pos['y']);

        if (in_array($curr_pos_str, $old_pos['visited'])) {
            $old_pos['twice'] = true;
            break;
        } else {
            $old_pos['visited'][] = $curr_pos_str;
        }
    }
        
    return $old_pos;
}

$myfile = fopen("day01_input.txt", "r") or die("Unable to open file!");
$instr_str = trim(fgets($myfile));
fclose($myfile);

$instructions = explode(", ", $instr_str);
$current = array("x" => 0, "y" => 0, "face" => "N", 'visited' => array("00"), "twice" => false);

foreach ($instructions as $instruction) {
    $turn_instr = substr($instruction, 0, 1);
    $walk_dist = intval(substr($instruction, 1));

    $current = walk(turn($current, $turn_instr), $walk_dist);

    if ($current['twice'] === true) {
        break;
    }
}

echo(abs($current['x']) + abs($current['y']));

?>
