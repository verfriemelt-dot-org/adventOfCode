<?php

    declare( strict_types = 1 );

    namespace year2021\day8;

    $input = explode( "\n", file_get_contents( __DIR__ . '/input' ) ?: '' );

//    $input = explode( "\n", file_get_contents( __DIR__ . '/input.simple' ) ?: '' );

    function sortString( string $in ): string {
        $data = str_split( $in );
        sort( $data );
        return implode( '', $data );
    }

    $simpleDigitsCount = 0;
    foreach ( $input as $line ) {

        [$in, $out] = explode( "|", $line, 2 );
        $in  = explode( " ", trim( $in ) );
        $out = explode( " ", trim( $out ) );

        foreach ( $out as $digit ) {
            if ( in_array( strlen( $digit ), [ 2, 3, 4, 7 ], true ) ) {
                $simpleDigitsCount++;
            }
        }
    }

    print_r( [
        '1,4,7,8 count: ' => $simpleDigitsCount
    ] );

