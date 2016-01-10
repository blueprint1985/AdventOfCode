<?php
function log_not($intArg) {
		$strArr = str_split(str_pad(decbin($intArg), 16, "0", STR_PAD_LEFT));
		for ($i = 0; $i < 16; $i++) { $strArr[$i] = ($strArr[$i] == "0") ? "1" : "0"; }
		return (bindec(implode($strArr)));
}

$GLOBALS['calculated'] = [];

function traverseTree($tree, $startNode) {
	if (is_numeric($startNode)) {
		return (int)$startNode;
	} else if (array_key_exists($startNode, $GLOBALS['calculated'])) {
		return (int)$GLOBALS['calculated'][$startNode];
	} else {
		$result = 0;
 
		$thisNode = $tree[$startNode];
		if (is_array($thisNode)) {
			switch ($thisNode[0]) {
				case "NOT":
						$result = log_not(traverseTree($tree, $thisNode[1]));
						break;
				case "AND":
						$result = ((int)traverseTree($tree, $thisNode[1]) & (int)traverseTree($tree, $thisNode[2]));
						break;
				case "OR":
						$result = ((int)traverseTree($tree, $thisNode[1]) | (int)traverseTree($tree, $thisNode[2]));
						break;
				case "RSHIFT":
						$result = ((int)traverseTree($tree, $thisNode[1]) >> (int)($thisNode[2]));
						break;
				case "LSHIFT":
						$result = ((int)traverseTree($tree, $thisNode[1]) << (int)($thisNode[2]));
						break;
				default:
						die("Do not enter default!");
			}
		} else {
			if (is_numeric($thisNode)) {
				$result = $thisNode;
			} else {
				$result = (int)traverseTree($tree, $thisNode);
			}
		}

		$GLOBALS['calculated'][$startNode] = $result;
		return $result;
	}
}

$logicTree = [];
 
$myfile = fopen("day7_input.txt", "r") or die("Unable to open file!");
 
while(!feof($myfile)) {
		$line = trim(fgets($myfile));
		$lineArr = explode(" ", $line);
	   
		if (count($lineArr) == 3) {
				$logicTree[$lineArr[2]] = $lineArr[0];
		} elseif (count($lineArr) == 4) {
				$logicTree[$lineArr[3]] = [$lineArr[0], $lineArr[1]];
		} else {
				$logicTree[$lineArr[4]] = [$lineArr[1], $lineArr[0], $lineArr[2]];
		}
}
 
fclose($myfile);

$logicTree["b"] = "16076"; //result from part 1

echo (traverseTree($logicTree, "a"));
?>