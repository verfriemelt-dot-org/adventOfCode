<?php

    $input = explode(',',file_get_contents('input'));
//    $input = explode(',',file_get_contents('input.simple'));
    $input = array_map(static fn($i) => (int) $i, $input);

    $costs = array_fill( 0, max( ... $input ), 0);

    for( $goalPosition = 0; $goalPosition <= max( ... $input ); $goalPosition++ ) {

        $costs[$goalPosition] = 0;
        foreach( $input as $currentPosition ) {

            $dist = abs( $currentPosition - $goalPosition);

            if ( $dist > 0 ) {
//                $costs[$goalPosition] += $dist;
                $costs[$goalPosition] += ($dist * ($dist+1)) / 2;
            }
        }
    }
    asort($costs);
    var_dump( array_shift( $costs ) );
