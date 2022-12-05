<?php

    declare( strict_types = 1 );

    namespace year2022\day3;

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
        foreach( $input as $rucksack ) {

            [$c1, $c2] = [
                array_slice(str_split($rucksack), 0, (int) (strlen($rucksack) /2)),
                array_slice(str_split($rucksack),(int) (strlen($rucksack)/2)),
            ];

            $intersection = array_intersect($c1,$c2);

            $values = array_combine([ ... range('a','z'), ... range('A','Z')], range(1,52));
            $part1 += $values[current($intersection)];
        }

        while(count($input) > 0 ) {

            /** @phpstan-ignore-next-line */
            $c1 = str_split(array_shift($input) ?? throw new \RuntimeException);
            /** @phpstan-ignore-next-line */
            $c2 = str_split(array_shift($input) ?? throw new \RuntimeException);
            /** @phpstan-ignore-next-line */
            $c3 = str_split(array_shift($input) ?? throw new \RuntimeException);

            $intersection = array_intersect($c1,$c2,$c3);

            $values = array_combine([ ... range('a','z'), ... range('A','Z')], range(1,52));
            $part2 += $values[current($intersection)];
        }

        return [
            'part1' => $part1,
            'part2' => $part2,
        ];

    };

