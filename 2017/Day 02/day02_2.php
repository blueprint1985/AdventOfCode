<?php

$myfile = fopen("day02_input.txt", "r") or die("Unable to open file!");
$instr_arr = array();

$spreadsheet_arr = [];

while(!feof($myfile)) {
    $spreadsheet_arr[] = trim(fgets($myfile));
}

fclose($myfile);

$result = 0;

foreach ($spreadsheet_arr as $row) {
    $clean_row = array_filter(explode(" ", $row));

    foreach ($clean_row as $i => $outer) {
        foreach ($clean_row as $j => $inner) {
            $division = (intval($outer) / intval($inner));

            if ($i !== $j && is_int($division)) {
                $result += $division;
            }
        }
    }
}

echo($result);

?>
