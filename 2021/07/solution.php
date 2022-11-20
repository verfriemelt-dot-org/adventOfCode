<?php

    declare( strict_types = 1 );

    namespace year2021\day7;

    return;

    /** @phpstan-ignore-next-line */
    $input = explode( ',', file_get_contents( 'input' ) ?: '' );
//    $input = explode( ',', file_get_contents( 'input.simple' ) ?: '' );
    $input = array_map( static fn( $i ) => (int) $i, $input );

    $costs = [
        'simple'      => array_fill( 0, max( ... $input ) + 1, 0 ),
        'progression' => array_fill( 0, max( ... $input ) + 1, 0 ),
    ];

    for ( $goalPosition = 0; $goalPosition <= max( ... $input ); $goalPosition++ ) {

        foreach ( $input as $currentPosition ) {

            $dist = abs( $currentPosition - $goalPosition );

            if ( $dist > 0 ) {
                $costs['simple'][$goalPosition]      += $dist;
                $costs['progression'][$goalPosition] += ($dist * ($dist + 1)) / 2;
            }
        }
    }
    asort( $costs['simple'] );
    asort( $costs['progression'] );
    var_dump( [
        array_shift( $costs['simple'] ),
        array_shift( $costs['progression'] ),
    ] );
