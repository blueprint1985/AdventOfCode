
<?php

function getThreeLetterPalindromes($string_to_check) {
    $threeletter_palindromes = array();

    for ($i=0; $i < (strlen($string_to_check) - 2); $i++) {
        $threeletter = substr($string_to_check, $i, 3);
        $threeletter_arr = str_split($threeletter);

        if ($threeletter_arr[0] === $threeletter_arr[2] && $threeletter_arr[0] !== $threeletter_arr[1]) {
            $palindrome_arr = str_split($threeletter);
            $middle_char = $palindrome_arr[1];
            $palindrome_arr[1] = $palindrome_arr[0];
            $palindrome_arr[0] = $middle_char;
            $palindrome_arr[2] = $middle_char;
            $threeletter_palindromes[] = implode($palindrome_arr);
        }
    }

    return $threeletter_palindromes;
}

$myfile = fopen("day07_input.txt", "r") or die("Unable to open file!");
while(!feof($myfile)) {
    $ip_arr[] = trim(fgets($myfile));
}
fclose($myfile);

$supports_ssl = 0;

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

    $supernet_wanted_palindromes = array();

    foreach ($hypernets as $hypernet) {
        $supernet_wanted_palindromes = array_merge($supernet_wanted_palindromes, getThreeLetterPalindromes($hypernet));
    }

    $valid_ip = false;

    foreach ($supernets as $supernet) {
        foreach ($supernet_wanted_palindromes as $supernet_wanted_palindrome) {
            if (strpos($supernet, $supernet_wanted_palindrome) !== false) {
                $valid_ip = true;
                break 2;
            }
        }
    }

    if ($valid_ip) {
        $supports_ssl++;
    }
}

echo($supports_ssl);

?>
