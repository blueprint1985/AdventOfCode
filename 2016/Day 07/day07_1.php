
<?php

function checkHasFourLetterPalindrome($string_to_check) {
    $has_fourletter_palindrome = false;

    for ($i=0; $i < (strlen($string_to_check) - 3); $i++) {
        $fourletter = substr($string_to_check, $i, 4);
        $fourletter_arr = str_split($fourletter);

        if ($fourletter_arr[0] === $fourletter_arr[3] && $fourletter_arr[1] === $fourletter_arr[2] && $fourletter_arr[0] !== $fourletter_arr[1]) {
            $has_fourletter_palindrome = true;
            break;
        }
    }

    return $has_fourletter_palindrome;
}

$myfile = fopen("day07_input.txt", "r") or die("Unable to open file!");
while(!feof($myfile)) {
    $ip_arr[] = trim(fgets($myfile));
}
fclose($myfile);

$supports_tls = 0;

foreach ($ip_arr as $ip) {
    $single_ip_arr = preg_split("/(\[|\])/", $ip);
    $hypernets = array();
    $supernets = array();

    foreach ($single_ip_arr as $single_ip_key => $single_ip) {
        if ($single_ip_key % 2 === 0) {
            $supernets[] = $single_ip;
        } else {
            $hypernets[] = $single_ip;
        }
    }

    $valid_ip = true;

    foreach ($hypernets as $hypernet) {
        if (checkHasFourLetterPalindrome($hypernet)) {
            $valid_ip = false;
            break;
        }
    }

    if (!$valid_ip) {
        continue;
    }

    $valid_ip = false;

    foreach ($supernets as $supernet) {
        if (checkHasFourLetterPalindrome($supernet)) {
            $valid_ip = true;
            break;
        }
    }

    if ($valid_ip) {
        $supports_tls++;
    }
}

echo($supports_tls);

?>
