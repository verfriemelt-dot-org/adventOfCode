<?php

declare( strict_types = 1 );

namespace year2020\day5;

use function array_fill;
use function array_keys;
use function str_split;

return static function ( string $input ): array {

    $input = explode( "\n", $input );

    [ $part1, $part2 ] = [ null, null ];

    $maxSeatId = 0;

    $seats = array_fill(8*10 + 7, 883 - (8*10 + 7) , true);

    foreach ( $input as $line ) {
        $row = bindec(
            implode(
                '',
                array_map( fn ( string $c ): string => $c === 'F' ? "0" : "1", array_slice( str_split( $line ), 0,7 ) )
            )
        );
        $column = bindec(
            implode(
                '',
                array_map( fn ( string $c ): string => $c === 'L' ? "0" : "1", array_slice( str_split( $line ), 7,9 ) )
            )
        );

        // remove seat from list
        foreach($seats as $idx => $id) {
            if ($idx === $row*8+$column) {
                unset($seats[$idx]);
                break;
            }
        }

        $maxSeatId = max($row*8+$column,$maxSeatId);
    }

    return [
        'part1' => $maxSeatId,
        'part2' => count($input) === 1 ? null : current(array_keys($seats)),
    ];
};

