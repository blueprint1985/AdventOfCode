<?php

$myfile = fopen("day12_input.txt", "r") or die("Unable to open file!");
$instr_arr = array();

while(!feof($myfile)) {
    $instr_arr[] = trim(fgets($myfile));
}

fclose($myfile);

$registers = array('a' => 0, 'b' => 0, 'c' => 1, 'd' => 0);
$counter = 0;

while (count($instr_arr) > $counter) {
    $this_instr = explode(" ", $instr_arr[$counter]);

    if ($this_instr[0] === "cpy") {
        if (is_numeric($this_instr[1])) {
            $registers[$this_instr[2]] = intval($this_instr[1]);
        } else {
            $registers[$this_instr[2]] = intval($registers[$this_instr[1]]);
        }

        $counter++;
        continue;
    }

    if ($this_instr[0] === "inc") {
        $registers[$this_instr[1]]++;
        $counter++;
        continue;
    }

    if ($this_instr[0] === "dec") {
        $registers[$this_instr[1]]--;
        $counter++;
        continue;
    }


    if ($this_instr[0] === "jnz") {
        if (is_numeric($this_instr[1])) {
            if (intval($this_instr[1]) !== 0) {
                $counter += intval($this_instr[2]);
            } else {
                $counter++;
            }
        } else {
            if (intval($registers[$this_instr[1]]) !== 0) {
                $counter += intval($this_instr[2]);
            } else {
                $counter++;
            }
        }

        continue;
    }
}

echo $registers['a'];

?>
