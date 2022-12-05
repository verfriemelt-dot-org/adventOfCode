<?php

    declare( strict_types = 1 );

    namespace year2022\day4;

    use function array_combine;
    use function array_intersect;
    use function array_shift;
    use function array_slice;
    use function sort;
    use function str_split;

    return static function ( string $input): array {

        $input = explode( "\n", $input);

        $part1 = 0;
        $part2 = 0;

        foreach( $input as $group ) {

            $sections = explode(',', $group);
            $sectionA = explode('-', $sections[0]);
            $sectionB = explode('-', $sections[1]);

            $a = range( $sectionA[0], $sectionA[1] );
            $b = range( $sectionB[0], $sectionB[1] );

            $intersection = array_intersect($a,$b);

            if ( count($intersection) >= count($a) || count($intersection) >= count($b)  ) {
                $part1++;
            }

            if ( count($intersection) > 0 ) {
                $part2++;
            }
        }

        return [
            'part1' => $part1,
            'part2' => $part2,
        ];

    };

