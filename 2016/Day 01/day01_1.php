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

function walk($old_pos, $walk_dist) {
    if ($old_pos['face'] === "N") {
        $old_pos['y'] -= $walk_dist;
        return $old_pos;
    }

    if ($old_pos['face'] === "S") {
        $old_pos['y'] += $walk_dist;
        return $old_pos;
    }

    if ($old_pos['face'] === "W") {
        $old_pos['x'] -= $walk_dist;
        return $old_pos;
    }

    if ($old_pos['face'] === "E") {
        $old_pos['x'] += $walk_dist;
        return $old_pos;
    }
}

$myfile = fopen("day01_input.txt", "r") or die("Unable to open file!");
$instr_str = trim(fgets($myfile));
fclose($myfile);

$instructions = explode(", ", $instr_str);
$current = array("x" => 0, "y" => 0, "face" => "N");

foreach ($instructions as $instruction) {
    $turn_instr = substr($instruction, 0, 1);
    $walk_dist = intval(substr($instruction, 1));

    $current = walk(turn($current, $turn_instr), $walk_dist);
}

echo(abs($current['x']) + abs($current['y']));

?>
