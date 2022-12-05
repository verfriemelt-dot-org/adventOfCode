<?php

    declare( strict_types = 1 );

    namespace year2022\day2;

    use function array_slice;
    use function sort;

    return static function ( string $input): array {

        $input = explode( "\n", $input);

        $map = [
            "A" => 1, // rock
            "B" => 2, // paper
            "C" => 3, // scissors
            "X" => 1, // rock
            "Y" => 2, // paper
            "Z" => 3, // scissors
        ];

        // y draw, x loose, z win
        $map2 = [
            "A" => [ "Y" => 1 + 3, "X" => 3, "Z" => 2 + 6],
            "B" => [ "Y" => 2 + 3, "X" => 1, "Z" => 3 + 6],
            "C" => [ "Y" => 3 + 3, "X" => 2, "Z" => 1 + 6],
        ];

        $score = 0;
        $scorePart2 = 0;

        foreach( $input as $game ) {
            $score += match($game) {

                // draws
                "A X", "B Y", "C Z" => 3,

                // rock
                "A Y" => 6,
                "A Z" => 0,

                // paper
                "B X" => 0,
                "B Z" => 6,

                // scissors
                "C X" => 6,
                "C Y" => 0,
                default => throw new \RuntimeException
            };

            $score += $map[$game[2]];
            $scorePart2 += $map2[$game[0]][$game[2]];
        }

        return [
            'part1' => $score,
            'part2' => $scorePart2,
        ];

    };

