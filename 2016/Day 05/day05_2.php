<?php

$myfile = fopen("day05_input.txt", "r") or die("Unable to open file!");
$door_id = trim(fgets($myfile));
fclose($myfile);

$password_arr = array();
$counter = 0;
$positions = array('0', '1', '2', '3', '4', '5', '6', '7');
$used = array();

while (count($password_arr) < 8) {
    $test_md5 = md5($door_id . intval($counter));
    if (substr($test_md5, 0, 5) === "00000" && in_array(substr($test_md5, 5, 1), $positions, FALSE) && !in_array(substr($test_md5, 5, 1), $used, FALSE)) {
        $password_arr[substr($test_md5, 5, 1)] = substr($test_md5, 6, 1);
        $used[] = substr($test_md5, 5, 1);
    }

    $counter++;
}

ksort($password_arr);
$password = implode($password_arr);

echo($password);

?>
