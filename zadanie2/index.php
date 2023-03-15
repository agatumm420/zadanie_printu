<?php
function findUniqueString(string $s): int{
    $count = [];
    $len = strlen($s);

    for ($i = 0; $i < $len; $i++) {
        $char = $s[$i];
        if (!isset($count[$char])) {
            $count[$char] = ['count' => 1, 'index' => $i+1];
        } else {
            $count[$char]['count']++;
        }
    }

    foreach ($count as $char => $value) {
        if ($value['count'] == 1) {
            return $value['index'];
        }
    }

    return -1;
}
echo findUniqueString( "statistics");