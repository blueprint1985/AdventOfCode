<?php

ini_set('memory_limit', '512M');

function uncompress($compressed_string) {
    $decompressed_length = 0;

    while (strlen($compressed_string) > 0) {
        if (substr($compressed_string, 0, 1) === "(") {
            $end_marker_pos = strpos($compressed_string, ")");
            $marker = substr($compressed_string, 0, $end_marker_pos + 1);
            $compressed_string = substr($compressed_string, strlen($marker));
            $marker = substr($marker, 1, strlen($marker) - 2);
            list($data_length, $amount) = explode("x", $marker);
            $data_section = substr($compressed_string, 0, intval($data_length));
            $compressed_string = substr($compressed_string, strlen($data_section));

            for ($i=0; $i < intval($amount); $i++) { 
                $decompressed_length += uncompress($data_section);
            }
        } else {
            $decompressed_length++;
            $compressed_string = substr($compressed_string, 1);
        }
    }

    return $decompressed_length;
}

$myfile = fopen("day09_input.txt", "r") or die("Unable to open file!");
$compressed = trim(fgets($myfile));
fclose($myfile);

echo(uncompress($compressed));

?>
