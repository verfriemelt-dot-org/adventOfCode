<?php

    declare( strict_types = 1 );

    namespace year2021\day10;

$input = explode( "\n", file_get_contents( __DIR__ . '/input' ) ?: '' );
//    $input = explode( "\n", file_get_contents( __DIR__ . '/input.simple' ) ?: '' );

    $start = microtime( true );

    $stack  = [];
    $pos    = 0;
    $score  = 0;
    $counts = [
        ")" => 0,
        "]" => 0,
        "}" => 0,
        ">" => 0,
    ];

    foreach ( $input as $line ) {

        $pos   = 0;
        $stack = [];

        foreach ( str_split( $line ) as $chr ) {

            if ( in_array( $chr, [ ')', '}', "]", ">" ], true ) ) {
                $popped = array_pop( $stack );

                $isValid = match ( $chr ) {
                    ")" => $popped === '(',
                    "]" => $popped === '[',
                    "}" => $popped === '{',
                    ">" => $popped === '<',
                };

                if ( !$isValid ) {
                    $counts[$chr]++;
//                    throw new \RuntimeException("illegal at {$pos}: {$chr} => {$popped}");
                    continue 2;
                }
            } else {
                $stack[] = $chr;
            }

            $pos++;
        }
    }

    $score = $counts[")"] * 3 + $counts["]"] * 57 + $counts["}"] * 1197 + $counts[">"] * 25137;

    print_r( [
        "time"   => microtime( true ) - $start,
        "score"  => $score,
        "counts" => $counts
    ] );
