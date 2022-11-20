<?php

    declare( strict_types = 1 );

    namespace year2021\day6;

    return;

    /** @phpstan-ignore-next-line */
    $input = explode( ",", file_get_contents( __DIR__ . '/input' ) ?: '' );
//    $input = explode( ",", file_get_contents( __DIR__ . '/input.simple' ) ?: '' );

    $fish = array_map( fn( string $i ): int => (int) $i, $input );

    $day = 0;

    print_r( [ 'day' => 'initial', "fish" => implode( ', ', $fish ) ] );
    $timer = array_fill( 0, 9, 0 );

    foreach( $input as $i ) {
        $timer[$i]++;
    }

    while ( ++$day <= 256 ) {

        // fetch zeros
        $zeros = array_shift( $timer );

        // add them to reset value
        $timer[6] += $zeros;

        // add amount of new zeros as eights
        $timer = [
            ... $timer,
            $zeros
        ];

        print_r( [
            "day"       => $day,
            "fishCount" => array_sum( $timer ),
            "timer"     => $timer,
        ] );
    }
