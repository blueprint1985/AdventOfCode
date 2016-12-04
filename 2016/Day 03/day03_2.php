<?php

$myfile = fopen("day03_input.txt", "r") or die("Unable to open file!");
$lines_arr = array();

while(!feof($myfile)) {
    $lines_arr[] = trim(fgets($myfile));
}

fclose($myfile);

$t1 = array();
$t2 = array();
$t3 = array();

$sides_arr = array();

foreach ($lines_arr as $key => $value) {
    $temp_arr = explode(" ", $value);
    $removed = array();

    foreach ($temp_arr as $temp_val) {
        if ($temp_val !== "") {
            $removed[] = $temp_val;
        }
    }

    if ($key % 3 == 2) {
        $t1[] = $removed[0];
        $t2[] = $removed[1];
        $t3[] = $removed[2];

        $sides_arr[] = $t1;
        $sides_arr[] = $t2;
        $sides_arr[] = $t3;

        $t1 = [];
        $t2 = [];
        $t3 = [];
    } else {
        $t1[] = $removed[0];
        $t2[] = $removed[1];
        $t3[] = $removed[2];
    }
}

$valid_triangles = 0;

foreach ($sides_arr as $triangle) {
    $a = intval($triangle[0]);
    $b = intval($triangle[1]);
    $c = intval($triangle[2]);

    $ab = intval($triangle[0]) + intval($triangle[1]);
    $ac = intval($triangle[0]) + intval($triangle[2]);
    $bc = intval($triangle[1]) + intval($triangle[2]);

    if ($ab > $c && $ac > $b && $bc > $a) {
        $valid_triangles++;
    }
}

echo($valid_triangles);

?>
