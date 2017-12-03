<?php

function walk($x, $y, $next_walk) {
    switch ($next_walk) {
        case 'right':
            $x++;
            break;

        case 'up':
            $y--;
            break;

        case 'left':
            $x--;
            break;

        case 'down':
            $y++;
            break;
        
        default:
            break;
    }

    return $x.":".$y;
}

function calc($x, $y, $square) {
    $curr_add = 0;

    $curr_add += intval($square[($x+1) . ":" . ($y  )]);
    $curr_add += intval($square[($x+1) . ":" . ($y-1)]);
    $curr_add += intval($square[($x  ) . ":" . ($y-1)]);
    $curr_add += intval($square[($x-1) . ":" . ($y-1)]);
    $curr_add += intval($square[($x-1) . ":" . ($y  )]);
    $curr_add += intval($square[($x-1) . ":" . ($y+1)]);
    $curr_add += intval($square[($x  ) . ":" . ($y+1)]);
    $curr_add += intval($square[($x+1) . ":" . ($y+1)]);

    return $curr_add;
}

function turn($next_walk) {
    $turn = "";

    switch ($next_walk) {
        case 'right':
            $turn = "up";
            break;

        case 'up':
            $turn = "left";
            break;

        case 'left':
            $turn = "down";
            break;

        case 'down':
            $turn = "right";
            break;
        
        default:
            break;
    }

    return $turn;
}

$myfile = fopen("day03_input.txt", "r") or die("Unable to open file!");
$input = trim(fgets($myfile));
fclose($myfile);

$input = intval($input);

$square = array("0:0" => 1);
$next_walk = "right";
$curr_pos = "0:0";
$curr_add = 0;

while ($curr_add <= $input) {
    list($x, $y) = explode(":", $curr_pos);

    $curr_pos = walk($x, $y, $next_walk);

    list($x, $y) = explode(":", $curr_pos);
    $x = intval($x);
    $y = intval($y);

    $curr_add = calc($x, $y, $square);
    $square[$curr_pos] = $curr_add;

    if ($x === $y*-1 || ($x < 0 && $x === $y) || ($x > 0 && $x === $y+1)) {
        $next_walk = turn($next_walk);
    }
}

echo($curr_add);

?>
