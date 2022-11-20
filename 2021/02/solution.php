<?php

    declare( strict_types = 1 );

    namespace year2021\day2;

    use function explode;
    use function file_get_contents;

    return static function ( string $input ): array {

        $input = explode( "\n", $input );

        $p1 = [
            'horizontalPosition' => 0,
            'depth'              => 0,
        ];

        $p2 = [
            'aim'                => 0,
            'horizontalPosition' => 0,
            'depth'              => 0,
        ];

        foreach ( $input as $command ) {
            [$command, $amount] = explode( ' ', $command );

            switch ( $command ) {
                case 'forward':
                    $p1['horizontalPosition'] += (int) $amount;
                    $p2['horizontalPosition'] += (int) $amount;
                    $p2['depth']              += $p2['aim'] * (int) $amount;
                    break;
                case 'down':
                    $p1['depth']              += (int) $amount;
                    $p2['aim']                += (int) $amount;
                    break;
                case 'up':
                    $p1['depth']              -= (int) $amount;
                    $p2['aim']                -= (int) $amount;
                    break;
            }
        }

//        print_r( [
//            'horizontal' => $p1['horizontalPosition'],
//            'depth'      => $p1['depth'],
//            'product'    => $p1['horizontalPosition'] * $p1['depth'],
//        ] );
//
//        print_r( [
//            'horizontal' => $p2['horizontalPosition'],
//            'depth'      => $p2['depth'],
//            'aim'        => $p2['aim'],
//            'product'    => $p2['horizontalPosition'] * $p2['depth'],
//        ] );

        return [
            'part1' => $p1['horizontalPosition'] * $p1['depth'],
            'part2' => $p2['horizontalPosition'] * $p2['depth'],
        ];
    };



