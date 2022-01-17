<?php

    $input = explode( "\n", file_get_contents( 'input' ) ?: '' );
//    $input = explode( "\n", file_get_contents( 'input.simple' ) ?: '' );

    $position = 0;
    $depth    = 0;

    foreach ( $input as $command ) {
        [$command, $amount] = explode( ' ', $command );

        switch ( $command ) {
            case 'forward':
                $position += (int) $amount;
                break;
            case 'down':
                $depth    += (int) $amount;
                break;
            case 'up':
                $depth    -= (int) $amount;
                break;
        }
    }

    print_r( [
        'horizontal' => $position,
        'depth'      => $depth,
        'product'    => $position * $depth,
    ] );

