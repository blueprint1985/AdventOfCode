<?php

$myfile = fopen("day22_input.txt", "r") or die("Unable to open file!");

$bossStats = [];

while(!feof($myfile)) {
    $line = trim(fgets($myfile));
    $lineArr = explode(": ", $line);
    $bossStats[] = intval($lineArr[1]);
}

fclose($myfile);

$state = array(
    'bossHP' => $bossStats[0],
    'bossDmg' => $bossStats[1],
    'playerHP' => 50,
    'playerMana' => 500,
    'shieldTimer' => 0,
    'poisonTimer' => 0,
    'rechargeTimer' => 0,
    'manaSpent' => 0,
    'move' => 'player'
);

$spells = array(
    'missile' => array(53,4,0),
    'drain' => array(73,2,2),
    'shield' => array(113,6),
    'poison' => array(173,6),
    'recharge' => array(229,5)
);

$min = PHP_INT_MAX;
$moves = array($state);

while ($state = array_shift($moves)) {
    if ($state['move'] == 'player') $state['playerHP']--;

    if ($state['shieldTimer'] > 0) {
        $playerNewHP = $state['playerHP'] - max(1, $state['bossDmg'] - 7);
        $state['shieldTimer']--;
    } else {
        $playerNewHP = $state['playerHP'] - $state['bossDmg'];
    }    

    if ($state['poisonTimer'] > 0) {
        $state['bossHP'] -= 3;
        $state['poisonTimer']--;
    }

    if ($state['rechargeTimer'] > 0) {
        $state['playerMana'] += 101;
        $state['rechargeTimer']--;
    }

    if ($state['playerHP'] <= 0 || $state['manaSpent'] >= $min) continue;

    if ($state['bossHP'] <= 0) {
        $min = min($min, $state['manaSpent']);
        continue;
    }

    if ($state['move'] == 'bossHP') {
        $state['move'] = 'player';
        $state['playerHP'] = $playerNewHP;
        
        array_unshift($moves, $state);
    } else {
        $state['move'] = 'bossHP';
        foreach ($spells as $spell => $info) {
            if ($info[0] >= $state['playerMana']) continue;

            $n = $state;
            $n['playerMana'] -= $info[0];
            $n['manaSpent'] += $info[0];

            switch ($spell) {
                case 'missile':
                case 'drain':
                    $n['bossHP'] -= $info[1];
                    $n['playerHP'] += $info[2];
                    break;
                default:
                    if ($n[$spell.'Timer'] > 0) continue 2;
                    $n[$spell.'Timer'] = $info[1];
                    break;
            }

            array_unshift($moves, $n);
        }
    }
}

echo $min;

?>
