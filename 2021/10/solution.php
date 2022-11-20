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
    $scores = [];

    foreach ( $input as $line ) {

        $pos   = 0;
        $stack = [];
        $error = false;

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
                    $error = true;
//                    throw new \RuntimeException("illegal at {$pos}: {$chr} => {$popped}");
                    break;
                }
            } else {
                $stack[] = $chr;
            }

            $pos++;
        }

        if ( !$error ) {

            $fixup    = implode( '', $stack );
            $fixup    = str_replace( [ '(', "[", "{", "<" ], [ ")", "]", "}", ">" ], $fixup );
            $fixup    = strrev( $fixup );
            $fixScore = 0;

            foreach ( str_split( $fixup ) as $chr ) {
                $fixScore *= 5;
                $fixScore += match ( $chr ) {
                    ")" => 1,
                    "]" => 2,
                    "}" => 3,
                    ">" => 4,
                    default => throw new \RuntimeException( 'wut? ' )
                };
            }

            $scores[] = $fixScore;
        }
    }

    $score = $counts[")"] * 3 + $counts["]"] * 57 + $counts["}"] * 1197 + $counts[">"] * 25137;

    sort( $scores );

    print_r( [
        "time"   => microtime( true ) - $start,
        "score"  => $score,
        /** @phpstan-ignore-next-line */
        "scores" => $scores[floor( count( $scores ) / 2 )],
        "counts" => $counts
    ] );
