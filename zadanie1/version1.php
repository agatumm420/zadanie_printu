<?php
ini_set('memory_limit', '1024M');
function hashOrder($input) {
    $m = 10000019;
    $base = 10;
    $result = 0;

    $digits = str_split((string) $input);
    foreach ($digits as $digit) {
        $result = ($result * $base + (int) $digit) % $m;
    }

    $hash = str_pad((string) $result, 7, '0', STR_PAD_LEFT);

    while (isset($unique[$hash])) {
        $input++;
        $result = ($result - pow($base, count($digits) - 1) * (int) $digits[0]) * $base + (int) $digits[count($digits) - 1];
        array_shift($digits);
        array_push($digits, (string) ($input % 10));
        $hash = str_pad((string) ($result % $m), 7, '0', STR_PAD_LEFT);
    }

    $unique[$hash] = true;

    return $hash;
}
$unique = [];

echo "Starting test ....".PHP_EOL;
$start = microtime(true);

for ($i=1; $i<=9999999; $i++) {
    $result = hashOrder($i);

    if (!preg_match("/^[0-9]{7}$/", $result)) {
        throw new InvalidArgumentException("Result {$result} does not match regex");
    }

    if (!empty($unique[$result])) {
        throw new InvalidArgumentException("Colision detected for key {$i}:{$unique[$result]} and result {$result}");
    }

    $unique[$result] = $i;
}

$time_elapsed_secs = microtime(true) - $start;

if ($time_elapsed_secs > 60) {
    throw new InvalidArgumentException("Could not finish test in 60 seconds");
}

echo "Finished in {$time_elapsed_secs}";