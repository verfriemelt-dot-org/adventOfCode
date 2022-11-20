<?php

    declare( strict_types = 1 );

    namespace year2020\day1;

    use function print_r;
    use function str_word_count;

    return static function ( string $input): array {

        $input = explode( "\n", $input);

        [$part1, $part2] = [null,null];

        $validCountPart1 = 0;
        $validCountPart2 = 0;

        foreach( $input as $line ) {

            if (false === preg_match('/(?<min>[0-9]+)\-(?<max>[0-9]+)\s(?<char>[a-z]):\s(?<pass>[a-z]+)/', $line, $matches)) {
                continue;
            }

            $count = substr_count($matches['pass'], $matches['char']);

            if ( $count >= $matches['min'] && $count <= $matches['max']) {
                $validCountPart1++;
            }

            if ( $matches['pass'][$matches['min'] - 1] === $matches["char"] &&
                 $matches['pass'][$matches['max'] - 1] !== $matches["char"]
            ) {
                $validCountPart2++;
                continue;
            }

            if ( $matches['pass'][$matches['max'] - 1] === $matches["char"] &&
                 $matches['pass'][$matches['min'] - 1] !== $matches["char"]
            ) {
                $validCountPart2++;
            }
        }

        return [
            'part1' => $validCountPart1,
            'part2' => $validCountPart2,
        ];

    };

