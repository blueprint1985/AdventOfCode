<?php

$myfile = fopen("day03_input.txt", "r") or die("Unable to open file!");
$sides_arr = array();

while(!feof($myfile)) {
    $sides_arr[] = trim(fgets($myfile));
}

fclose($myfile);

$valid_triangles = 0;

foreach ($sides_arr as $value) {
    $temp_arr = explode(" ", $value);
    $triangle = array();

    foreach ($temp_arr as $temp_val) {
        if ($temp_val !== "") {
            $triangle[] = $temp_val;
        }
    }

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
