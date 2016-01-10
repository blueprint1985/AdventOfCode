<?php

$myfile = fopen("day10_input.txt", "r") or die("Unable to open file!");

$line = trim(fgets($myfile));

fclose($myfile);

$count = 0;

while ($count < 50) {
    $line = preg_replace_callback('#(.)\1*#', function($x) { return strlen($x[0]).$x[0][0];}, $line);
    $count++;
}

echo strlen($line);


?>