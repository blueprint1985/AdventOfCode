<?php

$myfile = fopen("day10_input.txt", "r") or die("Unable to open file!");
$instr_arr = array();

while(!feof($myfile)) {
    $instr_arr[] = trim(fgets($myfile));
}

fclose($myfile);

$bots = array();
$outputs = array();

while(count($instr_arr) > 0) {
    $key_to_remove = "";

    foreach ($instr_arr as $key => $value) {
        $value_arr = explode(" ", $value);

        if ($value_arr[0] === "value") {
            $bots[$value_arr[5]][] = $value_arr[1];
            $key_to_remove = $key;
            break;
        } else {
            if (array_key_exists($value_arr[1], $bots) && count($bots[$value_arr[1]]) === 2) {
                sort($bots[$value_arr[1]], SORT_NUMERIC);

                if ($bots[$value_arr[1]][0] === "17" && $bots[$value_arr[1]][1] === "61") {
                    $correct_bot_number = $value_arr[1];
                    break 2;
                } else {
                    if ($value_arr[5] === "output") {
                        $outputs[$value_arr[6]][] = $bots[$value_arr[1]][0];
                    } else {
                        $bots[$value_arr[6]][] = $bots[$value_arr[1]][0];
                    }

                    if ($value_arr[10] === "output") {
                        $outputs[$value_arr[11]][] = $bots[$value_arr[1]][1];
                    } else {
                        $bots[$value_arr[11]][] = $bots[$value_arr[1]][1];
                    }

                    $bots[$value_arr[1]] = [];
                    $key_to_remove = $key;
                    break;
                }
            }
        }
    }

    array_splice($instr_arr, $key_to_remove, 1);
}

echo($correct_bot_number);

?>
