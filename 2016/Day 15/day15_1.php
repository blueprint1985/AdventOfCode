<?php

$myfile = fopen("day15_input.txt", "r") or die("Unable to open file!");
$disc_arr = array();

while(!feof($myfile)) {
    $disc_arr[] = trim(fgets($myfile));
}

fclose($myfile);

$all_discs = array();

foreach ($disc_arr as $disc) {
	$this_disc = explode(" ", $disc);
	$pos_amount = intval($this_disc[3]);
	$curr_pos = intval(str_replace(".", "", $this_disc[11]));
	$all_discs[] = array("amount" => $pos_amount, "current" => $curr_pos);
}

$goes_through = false;
$time = 0;

while (!$goes_through) {
    $passed_all = true;

    foreach ($all_discs as $pos => $disc) {
        $this_pos = $disc["current"];
        $pos_when_pass = ($this_pos + $pos + 1) % $disc["amount"];
        
        if ($pos_when_pass !== 0) {
            $passed_all = false;
        }

        $all_discs[$pos]['current']++;
        if ($all_discs[$pos]['current'] === $disc["amount"]) {
            $all_discs[$pos]['current'] = 0;
        }
    }

    $goes_through = $passed_all;
    $time++;
}

echo ($time-1);

?>
