<?php

    declare( strict_types = 1 );

    namespace year2020\day3;

    use function print_r;
    use function str_split;
    use function str_word_count;

    return static function ( string $input): array {

        $input = explode( "\n", $input);

        $map = [];

        foreach( $input as $line ) {
            $map[] = str_split($line);
        }

        [$part1, $part2] = [null,null];

        $treeCount = 0;

        $treeCounter = [
             [ 'down' => 1, 'right' => 1, 'count' => 0 ],
             [ 'down' => 1, 'right' => 3, 'count' => 0 ],
             [ 'down' => 1, 'right' => 5, 'count' => 0 ],
             [ 'down' => 1, 'right' => 7, 'count' => 0 ],
             [ 'down' => 2, 'right' => .5, 'count' => 0 ],
        ];


        for($i = 1; $i < count($map); $i++ ) {

            foreach($treeCounter as &$type ) {

                if ( $type['down'] > 1 && (1-$i % $type['down'] === 0)) {
                    continue;
                }

                if ( $map[$i][($i * $type['right']) % (count($map[0]))] === '#' ) {
                    $type['count']++;
                }
            }
        }

        $mul = null;

        foreach( $treeCounter as $counter) {

            if ( $mul === null ) {
                $mul = $counter['count'];
            } else {
                $mul *= $counter['count'];
            }
        }

        return [
            'part1' => $treeCounter[1]['count'],
            'part2' => $mul,
        ];

    };

