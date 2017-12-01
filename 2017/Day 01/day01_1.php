<?php

$myfile = fopen("day01_input.txt", "r") or die("Unable to open file!");
$captcha = trim(fgets($myfile));
fclose($myfile);

$sum = 0;
$list = str_split($captcha);

$i = 0;
while ($i < count($list) - 1) { 
    if ($list[$i] === $list[$i+1]) {
        $sum += intval($list[$i], 10);
    }

    $i++;
}

if ($list[$i] === $list[0]) {
    $sum += intval($list[$i], 10);
}

echo($sum);

?>
