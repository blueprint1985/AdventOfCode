<?php

$myfile = fopen("day05_input.txt", "r") or die("Unable to open file!");
$door_id = trim(fgets($myfile));
fclose($myfile);

$password = "";
$counter = 0;

while (strlen($password) < 8) {
    $test_md5 = md5($door_id . intval($counter));
    if (substr($test_md5, 0, 5) === "00000") {
        $password .= substr($test_md5, 5, 1);
    }

    $counter++;
}

echo($password);

?>
