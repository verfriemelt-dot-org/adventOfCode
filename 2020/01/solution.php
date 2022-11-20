<?php

    declare( strict_types = 1 );

    namespace year2020\day1;

    use function print_r;

    return static function ( string $input): array {

        $input = explode( "\n", $input);

        $factorA = 0;
        $factorB = 0;

        foreach($input as $a) {
            $factorA = (int) $a;

            foreach($input as $b) {
                $factorB = (int) $b;

                if ( (int)$a + (int)$b === 2020 ) {
                    break 2;
                }
            }
        }

        $part1 = $factorA * $factorB;

        $factorA = 0;
        $factorB = 0;
        $factorC = 0;

        foreach($input as $a) {
            $factorA = (int) $a;

            foreach($input as $b) {
                $factorB = (int) $b;

                foreach($input as $c) {
                    $factorC = (int) $c;

                    if ( (int)$a + (int)$b + (int)$c=== 2020 ) {
                        break 3;
                    }
                }
            }
        }

        $part2 = $factorA * $factorB * $factorC;

//        print_r([
//            $factorA , $factorB, $factorC
//        ]);

        return [
            'part1' => $part1,
            'part2' => $part2,
        ];

    };

