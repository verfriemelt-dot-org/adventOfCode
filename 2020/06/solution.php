<?php

declare( strict_types = 1 );

namespace year2020\day6;

use function array_count_values;
use function explode;
use function str_split;

return static function ( string $input ): array {

    $input = explode( "\n\n", $input );

    [ $part1, $part2 ] = [ null, null ];

    $sumA = 0;
    $sumB = 0;

    foreach($input as $group) {

        $answers = array_merge(... array_map(
            fn(string $i): array => str_split($i),
            explode("\n", $group)
        ));

        $a = array_unique($answers);
        $b = array_filter(array_count_values($answers), fn($v): bool => ($v === count(explode("\n", $group))));

        $sumA += count($a);
        $sumB += count($b);
    }

    return [
        'part1' => $sumA,
        'part2' => $sumB,
    ];
};

