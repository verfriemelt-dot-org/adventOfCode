<?php

    $input = explode( "\n", file_get_contents( 'input' ) );
//    $input = explode( "\n", file_get_contents( 'input.simple' ) );
    $input = array_map( static fn( $i ) => (int) $i, $input );

    $incrementCount = 0;
    $slidingCount   = 0;

    for ( $i = 1; $i < count( $input ); $i++ ) {

        $incrementCount += $input[$i] > $input[$i - 1] ? 1 : 0;

        if ( $i < 3 ) {
            continue;
        }

        $currentSlice = array_sum( array_slice( $input, $i - 2, 3 ) );
        $prevSlice    = array_sum( array_slice( $input, $i - 3, 3 ) );

        $slidingCount += $currentSlice > $prevSlice  ? 1 : 0;
    }

    var_dump( [
        'simple increments' => $incrementCount,
        'sliding window' =>  $slidingCount,
    ] );

