<?php

/**
 * Class for running all problems
 *
 * @author Martin Björling <martinbjorling@gmail.com>
 * @license MIT
 * @copyright Martin Björling 2015 - 2018
 */
class Run {
    /**
     * findDayFromArguments
     *
     * Search command line arguments for the day to run
     *
     * @param array $args Command line arguments
     * @return string|bool The day in the arguments or false
     */
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

    /**
     * findPartsFromArguments
     *
     * Search command line arguments for which parts to run
     *
     * @param array $args Command line arguments
     * @return array The parts to run
     */
    public function findPartsFromArguments(array $args) : array {
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

    /**
     * fetchInput
     *
     * Get input from input file. If the input only has one line, the return
     * should be a string, otherwise an array.
     *
     * @param string $url THe location of the input file
     * @return string|array The input as string or array
     */
    public function fetchInput(string $url) {
        $myfile = @fopen($url, "r") or die(PHP_EOL."ERROR: Unable to open file ".$url.PHP_EOL);
        $input = [];

        while(!feof($myfile)) {
            $input[] = trim(fgets($myfile), "\t\n\r\0\x0B");
        }

        fclose($myfile);

        if (count($input) === 1) {
            $input = $input[0];
        }

        return $input;
    }

    /**
     * runPart
     *
     * Rin each part with timing
     *
     * @param Base $part Which part to run
     * @return array Solution and runtime as array
     */
    public function runPart(Base $part) : array {
        $start_time = microtime(true);
        $solution = $part->solve();
        $end_time = microtime(true);

        $runtime = $end_time - $start_time;

        return array($solution, $runtime);
    }
}

if (in_array("-h", $argv) || in_array("--help", $argv)) {
    echo "".PHP_EOL;
    echo "Usage: php Run.php [day] [part(s)] [OPTIONS]".PHP_EOL;
    echo "Run AdventOfCode for day and part(s)".PHP_EOL;
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

$runner = new Run();
$day = $runner->findDayFromArguments($argv);
$parts_to_run = $runner->findPartsFromArguments($argv);

if ($day === false || empty($parts_to_run)) {
    echo "".PHP_EOL;
    echo "ERROR: Invalid argument(s). Please run \"php Run.php -h\" to see help section".PHP_EOL;
    exit(1);
}

$input_url = "./".$day."/Input.txt";

if (!file_exists($input_url)) {
    echo "".PHP_EOL;
    echo "ERROR: Input file does not exist at location ".$day.". Make sure that both the day folder and file exists".PHP_EOL;
    exit(1);
}

$fetched_input = $runner->fetchInput($input_url);

foreach ($parts_to_run as $part_name) {
    $part_file = "./".$day."/".$part_name.".php";

    if (!file_exists($part_file)) {
        echo "".PHP_EOL;
        echo "ERROR: Part file does not exist at location ".$day.". Make sure that the file exists".PHP_EOL;
        exit(1);
    }

    require "./".$day."/".$part_name.".php";

    $part = new $part_name($fetched_input);
    list($solution, $runtime) = $runner->runPart($part);

    echo "".PHP_EOL;
    echo("***** Result ".$part_name.": ".$solution.PHP_EOL);
    echo("***** Execution time: ".$runtime." seconds".PHP_EOL);
}

?>
