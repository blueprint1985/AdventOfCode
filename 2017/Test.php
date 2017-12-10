<?php

class Test {
    public function findDayFromArguments(array $args) {
        $days = array();

        foreach ($args as $arg) {
            $lower = trim(strtolower($arg));

            if (preg_match('/^(day)(\d\d)$/', $lower)) {
                $days[] = ucfirst($lower);
            }
        }

        if (count($days) === 0 || count($days) > 1) {
            return false;
        } else {
            return $days[0];
        }
    }

    public function findPartsFromArguments(array $args) {
        $parts = array();

        foreach ($args as $arg) {
            $lower = strtolower($arg);

            if ($arg === "both") {
                $parts[] = "PartOne";
                $parts[] = "PartTwo";
            } else if ($arg === "one") {
                $parts[] = "PartOne";
            } else if ($arg === "two") {
                $parts[] = "PartTwo";
            }
        }

        return array_unique($parts);
    }

    public function fetchInput(string $url) {
        return json_decode(file_get_contents($url), true);
    }

    public function runPart(Base $part) {
        $start_time = microtime(true);
        $solution = $part->solve();
        $end_time = microtime(true);

        $runtime = $end_time - $start_time;

        return array($solution, $runtime);
    }
}

if (in_array("-h", $argv) || in_array("--help", $argv)) {
    echo "".PHP_EOL;
    echo "Usage: php Test.php [day] [part(s)] [OPTIONS]".PHP_EOL;
    echo "Test AdventOfCode for day and part(s)".PHP_EOL;
    echo "".PHP_EOL;
    echo "Arguments:".PHP_EOL;
    echo "  [day]        Which day that should be run. Mandatory. Only one day allowed per run".PHP_EOL;
    echo "  [part(s)]    If part \"one\", \"two\" or \"both\" should be run. Multiple parts possible".PHP_EOL;
    echo "".PHP_EOL;
    echo "OPTIONS:".PHP_EOL;
    echo "  -h  --help   Show help section. Cannot be used together with other arguments or options".PHP_EOL;
  exit(0);
}

error_reporting(E_ALL);

require "./Base.php";

$tester = new Test();
$day = $tester->findDayFromArguments($argv);
$parts_to_run = $tester->findPartsFromArguments($argv);

if ($day === false || empty($parts_to_run)) {
    echo "".PHP_EOL;
    echo "ERROR: Invalid argument(s). Please run \"php Test.php -h\" to see help section".PHP_EOL;
    exit(1);
}

$input_url = "./".$day."/Tests.json";

if (!file_exists($input_url)) {
    echo "".PHP_EOL;
    echo "ERROR: Input file does not exist at location ".$day.". Make sure that both the day folder and file exists".PHP_EOL;
    exit(1);
}

$test_data = $tester->fetchInput($input_url);

foreach ($parts_to_run as $part_name) {
    $part_file = "./".$day."/".$part_name.".php";

    if (!file_exists($part_file)) {
        echo "".PHP_EOL;
        echo "ERROR: Part file does not exist at location ".$day.". Make sure that the file exists".PHP_EOL;
        exit(1);
    }

    require "./".$day."/".$part_name.".php";

    $test_cases = $test_data[$part_name];

    if (empty($test_cases)) {
        echo "".PHP_EOL;
        echo "\033[01;30mNo test cases present for ".$part_name."\033[0m".PHP_EOL;
        echo "".PHP_EOL;
        continue;
    }

    echo "".PHP_EOL;
    echo "RUNNING TEST CASES FOR ".$part_name.PHP_EOL;
    echo "".PHP_EOL;

    foreach ($test_cases as $index => $case) {
        $fetched_input = explode("\n", $case["input"]);

        if (count($fetched_input) === 1) {
            $fetched_input = $fetched_input[0];

            echo "Testing \033[01;34m".$fetched_input."\033[0m: ".PHP_EOL.PHP_EOL;
        } else {
            echo "Testing input\033[01;34m".PHP_EOL.PHP_EOL.$case["input"]."\033[0m".PHP_EOL.PHP_EOL;
        }

        $part = new $part_name($fetched_input);
        list($solution, $runtime) = $tester->runPart($part);

        if (strval($solution) === strval($case["result"])) {
            echo "\033[00;32mCLEARED. Result: ".$solution.". Runtime: ".$runtime."\033[0m".PHP_EOL.PHP_EOL;
        } else {
            echo "\033[00;31mFAILED. Expected: ".$case["result"].", got: ".$solution.". Runtime: ".$runtime."\033[0m".PHP_EOL.PHP_EOL;
        }
    }
}

?>
