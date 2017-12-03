<?php

$myfile = fopen("day02_input.txt", "r") or die("Unable to open file!");
$spreadsheet_arr = array();

while(!feof($myfile)) {
    $spreadsheet_arr[] = trim(fgets($myfile));
}

fclose($myfile);

$start_time = microtime(true);

$result = 0;

foreach ($spreadsheet_arr as $row) {
    $clean_row = array_values(array_filter(explode(" ", $row)));
    $length = count($clean_row);

    for ($i = 0; $i < $length - 1; $i++) {
        for ($j = $i + 1; $j < $length; $j++) {
            $values = array($clean_row[$i], $clean_row[$j]);

            if (max($values) % min($values) === 0) {
                $result += max($values) / min($values);
            }
        }
    }
}

$end_time = microtime(true);

echo("Result: " . $result . "\n");
echo("Execution time: " . ($end_time - $start_time) . " seconds");

?>
