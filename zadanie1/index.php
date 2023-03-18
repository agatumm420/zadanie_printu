<?php
ini_set('memory_limit', '1024M');
#BEST ONE YET
function hashOrder($input) {
        $seed=666;
    $mod =9999999- $input % 9999999;

    $mod = str_pad($mod, 7, "0", STR_PAD_LEFT);


    $arr=str_split($mod);

    for ($i =strlen($mod) - 1; $i > 0; $i--) {
        $j = intval($seed/$i) %6;

        $tmp = $arr[$i];
        $arr[$i] = $arr[$j];
        $arr[$j] = $tmp;
    }





    return implode("", $arr);
}

$unique = [];

echo "Starting test ....".PHP_EOL;
//echo hashOrder(350).PHP_EOL;
$start = microtime(true);

for ($i=1; $i<=9999999; $i++) {
    $result = hashOrder($i);
//    echo $result.PHP_EOL;
    if (!preg_match("/^[0-9]{7}$/", $result)) {
        throw new InvalidArgumentException("Result {$result} does not match regex for inut {$i}");
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