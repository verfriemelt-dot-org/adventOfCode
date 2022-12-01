<?php

    declare( strict_types = 1 );

    namespace year2022\day1;

    use function array_slice;
    use function sort;

    return static function ( string $input): array {

        $input = explode( "\n\n", $input);

        $calsPerElf = [];

        foreach($input as $elf) {
            $cals = explode("\n",$elf );
            $calsPerElf[] = array_sum( array_map(static fn(string $i): int => (int) $i,$cals) );
        }

        sort($calsPerElf);
        end($calsPerElf);

        return [
            'part1' => current($calsPerElf),
            'part2' => array_sum(array_slice($calsPerElf, -3)),
        ];

    };

