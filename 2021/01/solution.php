<?php

    declare( strict_types = 1 );

    namespace year2021\day1;

    return static function (string $input): array {

        $input = explode( "\n", $input);
        $input = array_map( static fn( $i ) => (int) $i, $input );

        $incrementCount = 0;
        $slidingCount   = 0;

        for ( $i = 1; $i < count( $input ); $i++ ) {

            $incrementCount += $input[$i] > $input[$i - 1] ? 1 : 0;

            if ( $i < 3 ) {
                continue;
            }

            $currentSlice = array_sum( array_slice( $input, $i - 2, 3 ) );
            $prevSlice    = array_sum( array_slice( $input, $i - 3, 3 ) );

            $slidingCount += $currentSlice > $prevSlice ? 1 : 0;
        }

        return [
            'part1' => $incrementCount,
            'part2' => $slidingCount
        ];

    };

