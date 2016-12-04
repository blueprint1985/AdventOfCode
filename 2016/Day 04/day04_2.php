<?php

$myfile = fopen("day04_input.txt", "r") or die("Unable to open file!");
$rooms_arr = array();

while(!feof($myfile)) {
    $rooms_arr[] = trim(fgets($myfile));
}

fclose($myfile);

$alphabet = range('a', 'z');
array_unshift($alphabet, ' ');

$possible_rooms = array();

foreach ($rooms_arr as $value) {
    $temp_arr = explode("[", $value);
    $room_name = $temp_arr[0];
    $checksum = trim($temp_arr[1], "]");
    $room_name_arr = explode("-", $room_name);
    $room_id = intval(array_pop($room_name_arr));

    $actual_shift = $room_id % 26;
    $room_name_letter_arr = str_split(implode("-",$room_name_arr));

    foreach ($room_name_letter_arr as $letter_key => $letter) {
        if ($letter === "-") {
            $room_name_letter_arr[$letter_key] = $alphabet[0];
        } else {
            $old_pos = array_search($letter, $alphabet);
            $new_pos = $old_pos + $actual_shift;
            $new_pos = $new_pos > 26 ? $new_pos % 26 : $new_pos;
            $room_name_letter_arr[$letter_key] = $alphabet[$new_pos];
        }
    }

    $real_room_name = strtolower(implode($room_name_letter_arr));

    if (strpos($real_room_name, 'north') !== false) {
        $possible_rooms[] = array($real_room_name, $room_id);
    }
}

if (count($possible_rooms) > 1) {
    echo("Several possible:\n");
    foreach ($possible_rooms as $room) {
        echo($room[0].", id: ".$room[1]."\n");
    }
} else if (count($possible_rooms) < 1) {
    echo("No room found!");
} else {
    echo($possible_rooms[0][1]);
}

?>
