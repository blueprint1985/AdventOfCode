<?php

function getNewCoords($dir, $x, $y) {
    if ($dir === "U") {
        return array($x, $y-1);
    }

    if ($dir === "D") {
        return array($x, $y+1);
    }

    if ($dir === "L") {
        return array($x-1, $y);
    }

    if ($dir === "R") {
        return array($x+1, $y);
    }
}

function testRoomByDirection($x, $y, $lock) {
    $open_doors = array("b", "c", "d", "e", "f");

    if ($x < 0 || $x > 3 || $y < 0 || $y > 3) {
        return "wall";
    }

    if (!in_array($lock, $open_doors)) {
        return "locked";
    }

    if ($x === 3 && $y === 3) {
        return "finished";
    }

    return "ok";
}


$myfile = fopen("day17_input.txt", "r") or die("Unable to open file!");
$passcode = trim(fgets($myfile));
fclose($myfile);

$queue = array(array("code" => $passcode, "x" => 0, "y" => 0));
$directions = ["U", "D", "L", "R"];
$final_short_path = "s";

while (count($queue) > 0) {
    $to_test = array_shift($queue);
    $test_hash = str_split(substr(md5($to_test["code"]), 0, 4));

    foreach ($directions as $dir_key => $direction) {
        list($new_x, $new_y) = getNewCoords($direction, $to_test["x"], $to_test["y"]);
        $test_dir = testRoomByDirection($new_x, $new_y, $test_hash[$dir_key]);

        if ($test_dir === "finished") {
            $final_short_path = $to_test["code"].$direction;
            break 2;
        }

        if ($test_dir === "ok") {
            $queue[] = array("code" => $to_test["code"].$direction, "x" => $new_x, "y" => $new_y);
        }
    }
}

echo(substr($final_short_path, strlen($passcode)));

?>
