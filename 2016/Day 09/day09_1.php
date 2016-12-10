<?php

$myfile = fopen("day09_input.txt", "r") or die("Unable to open file!");
$compressed = trim(fgets($myfile));
fclose($myfile);

$decompressed = "";
$marker = "";
$data_section = "";

while (strlen($compressed) > 0) {
    if (substr($compressed, 0, 1) === "(") {
        $end_marker_pos = strpos($compressed, ")");
        $marker = substr($compressed, 0, $end_marker_pos + 1);
        $compressed = substr($compressed, strlen($marker));
        $marker = substr($marker, 1, strlen($marker) - 2);
        list($data_length, $amount) = explode("x", $marker);
        $data_section = substr($compressed, 0, intval($data_length));
        $compressed = substr($compressed, strlen($data_section));

        for ($i=0; $i < intval($amount); $i++) { 
            $decompressed .= $data_section;
        }
    } else {
        $decompressed .= substr($compressed, 0, 1);
        $compressed = substr($compressed, 1);
    }
}

$decompressed = str_replace(" ", "", $decompressed);

echo(strlen($decompressed));

?>
