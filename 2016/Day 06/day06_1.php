<?php

$myfile = fopen("day06_input.txt", "r") or die("Unable to open file!");
while(!feof($myfile)) {
    $msg_arr[] = str_split(trim(fgets($myfile)));
}
fclose($myfile);

$repetitions = count($msg_arr);
$message = "";
$counter = 0;

while ($counter < count($msg_arr[0])) {
    $column_letters = array();    

    for ($i=0; $i < $repetitions; $i++) { 
        $this_letter = $msg_arr[$i][$counter];

        if (array_key_exists($this_letter, $column_letters)) {
            $column_letters[$this_letter]++;
        } else {
            $column_letters[$this_letter] = 1;
        }
    }

    arsort($column_letters, SORT_NUMERIC);

    reset($column_letters);
    $message .= key($column_letters);

    $counter++;
}

echo($message);

?>
