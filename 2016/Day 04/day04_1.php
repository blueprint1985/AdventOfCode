<?php

$myfile = fopen("day04_input.txt", "r") or die("Unable to open file!");
$rooms_arr = array();

while(!feof($myfile)) {
    $rooms_arr[] = trim(fgets($myfile));
}

fclose($myfile);

$valid_rooms_id_sum = 0;

foreach ($rooms_arr as $value) {
    $temp_arr = explode("[", $value);
    $room_name = $temp_arr[0];
    $checksum = trim($temp_arr[1], "]");
    $room_name_arr = explode("-", $room_name);
    $room_id = intval(array_pop($room_name_arr));
    $letter_arr = str_split(implode($room_name_arr));

    $letter_amounts_arr = array();

    foreach ($letter_arr as $letter_key => $letter) {
        if (array_key_exists($letter, $letter_amounts_arr)) {
            $letter_amounts_arr[$letter]++;
        } else {
            $letter_amounts_arr[$letter] = 1;
        }
    }

    array_multisort(array_values($letter_amounts_arr), SORT_DESC, SORT_NUMERIC, array_keys($letter_amounts_arr), SORT_ASC, SORT_STRING, $letter_amounts_arr);

    $checksum_arr = str_split($checksum);
    $counter = 0;
    $is_real = true;

    foreach ($letter_amounts_arr as $value_key => $value) {
        if ($counter >= strlen($checksum)) {
            break;
        }

        if ($value_key !== $checksum_arr[$counter]) {
            $is_real = false;
            break;
        }

        $counter++;
    }

    if ($is_real === true) {
        $valid_rooms_id_sum += $room_id;
    }
}

echo($valid_rooms_id_sum);

?>
