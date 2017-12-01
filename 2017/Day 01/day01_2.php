<?php

$myfile = fopen("day01_input.txt", "r") or die("Unable to open file!");
$captcha = trim(fgets($myfile));
fclose($myfile);

$sum = 0;
$list = str_split($captcha);
$list_len = count($list);

$i = 0;
while ($i < $list_len - 1) { 
    if ($list[$i] === $list[($i+($list_len/2))%$list_len]) {
        $sum += intval($list[$i], 10);
    }

    $i++;
}

echo($sum);

?>
