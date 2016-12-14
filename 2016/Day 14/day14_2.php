<?php

$myfile = fopen("day14_input.txt", "r") or die("Unable to open file!");
$salt = trim(fgets($myfile));
fclose($myfile);

$curr_index = 0;
$all_keys = array();

while (count($all_keys) < 64) {
    $to_try = md5($salt.strval($curr_index));
    
    for ($j=0; $j < 2016; $j++) { 
        $to_try = md5($to_try);
    }

    preg_match('/(.)\1{2}/', $to_try, $matches);

    if (!empty($matches)) {
        $charStr = str_repeat($matches[1], 5);

        for ($i = $curr_index + 1; $i < $curr_index + 1001; $i++) { 
            $to_check = md5($salt.strval($i));

            for ($j=0; $j < 2016; $j++) { 
                $to_check = md5($to_check);
            }
            
            if (strpos($to_check, $charStr) !== false) {
                $all_keys[] = $to_try;
                break;
            }
        }
    }

    $curr_index++;
}

echo($curr_index-1);

?>
