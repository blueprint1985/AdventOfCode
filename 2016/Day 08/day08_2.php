<?php

function rect($screen, $x, $y) {
    for ($i=0; $i < $y; $i++) {
        for ($j=0; $j < $x; $j++) {
            $screen[$i][$j] = 1;
        }
    }

    return $screen;
}

function rotateRow($screen, $row, $amount) {
    $temp_row = $screen[$row];

    $all_ones = array_keys($temp_row, 1);
    $temp_row = array_fill(0, count($temp_row), 0);

    foreach ($all_ones as $value) {
        $value += $amount;
        $value = $value % count($temp_row);
        $temp_row[$value] = 1;
    }

    $screen[$row] = $temp_row;

    return $screen;
}

function rotateCol($screen, $col, $amount) {
    $temp_col = array();

    foreach ($screen as $row) {
        $temp_col[] = $row[$col];
    }

    $all_ones = array_keys($temp_col, 1);
    $temp_col = array_fill(0, count($temp_col), 0);

    foreach ($all_ones as $value) {
        $value += $amount;
        $value = $value % count($temp_col);
        $temp_col[$value] = 1;
    }

    foreach ($screen as $row_key => $row) {
        $row[$col] = $temp_col[$row_key];
        $screen[$row_key] = $row;
    }

    return $screen;
}

$myfile = fopen("day08_input.txt", "r") or die("Unable to open file!");
while(!feof($myfile)) {
    $instr_arr[] = trim(fgets($myfile));
}
fclose($myfile);

$screen = array_fill(0, 6, array_fill(0, 50, 0));

foreach ($instr_arr as $instr_key => $instr) {
    $single_instr_arr = explode(" ", $instr);

    if ($single_instr_arr[0] === "rect") {
        list($instr_x, $instr_y) = explode("x", $single_instr_arr[1]);
        $screen = rect($screen, intval($instr_x), intval($instr_y));
    } else {
        list(, $instr_num) = explode("=", $single_instr_arr[2]);

        if ($single_instr_arr[1] === "row") {
            $screen = rotateRow($screen, intval($instr_num), intval($single_instr_arr[4]));
        } else {
            $screen = rotateCol($screen, intval($instr_num), intval($single_instr_arr[4]));
        }
    }
}

foreach ($screen as $row) {
    $line = str_replace(1, "#", implode($row));
    $line = str_replace(0, " ", $line);

    echo($line."\n");
}

?>
