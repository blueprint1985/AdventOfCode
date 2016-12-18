<?php

$myfile = fopen("day18_input.txt", "r") or die("Unable to open file!");
$first_row = trim(fgets($myfile));
fclose($myfile);

$tot_rows = 40;
$row_len = strlen($first_row);
$safe_amount = substr_count($first_row, ".");
$this_row = $first_row;

for ($i=0; $i < $tot_rows-1; $i++) {
    $this_row_arr = str_split($this_row);
    $next_row_arr = array();

    foreach ($this_row_arr as $tile_key => $tile) {
        if ($tile_key === 0) {
            $next_row_arr[] = ($this_row_arr[1] === "^") ? "^" : ".";
            continue;
        }

        if ($tile_key === $row_len-1) {
            $next_row_arr[] = ($this_row_arr[$row_len-2] === "^") ? "^" : ".";
            continue;
        }

        $next_row_arr[] = ($this_row_arr[$tile_key-1] !== $this_row_arr[$tile_key+1]) ? "^" : ".";
    }

    $next_row = implode($next_row_arr);
    $safe_amount += substr_count($next_row, ".");
    $this_row = $next_row;
}

echo($safe_amount);

?>
