<?php

    $input = explode( "\n", file_get_contents( __DIR__ . '/input' ) ?: '' );
//    $input = explode( "\n", file_get_contents( __DIR__ . '/input.simple' ) ?: '' );

    $p1 = [
        'gamma'   => '',
        'epsilon' => '',
    ];

    $p2 = [
        'o2'  => '',
        'co2' => '',
    ];

    function getBitsAtOffset( array $input, int $number ): string {
        return array_reduce( $input, static fn( string $r, string $i ) => $r . $i[$number], '' );
    }

    $filterList = [
        'o2'  => $input,
        'co2' => $input,
    ];

    for ( $i = 0; $i < strlen( $input[0] ); $i++ ) {

        $histogram = array_filter( array_count_values( str_split( getBitsAtOffset( $input, $i ) ) ) );
        asort( $histogram );

        $mostCommon  = (string) array_keys( $histogram )[0];
        $leastCommon = (string) array_keys( $histogram )[1];

        $p1['epsilon'] .= $mostCommon;
        $p1['gamma']   .= $leastCommon;
    }

    $iteration = 0;
    while ( count( $filterList['o2'] ) > 1 ) {

        $histogram = array_filter( array_count_values( str_split( getBitsAtOffset( $filterList['o2'], $iteration ) ) ) );
        asort( $histogram );

        $mostCommon  = (string) array_keys( $histogram )[1];
        $leastCommon = (string) array_keys( $histogram )[0];

        $filterList['o2'] = array_filter( $filterList['o2'], static fn( string $input ): bool => $input[$iteration] === $mostCommon );
        $iteration++;
    }

    $iteration = 0;
    while ( count( $filterList['co2'] ) > 1 ) {

        $histogram = array_filter( array_count_values( str_split( getBitsAtOffset( $filterList['co2'], $iteration ) ) ) );
        asort( $histogram );

        $mostCommon = (string) array_keys( $histogram )[0];

        if ( $histogram[0] === $histogram[1] ) {
            $keep = "0";
        } else {
            $keep = $mostCommon;
        }

        $filterList['co2'] = array_filter( $filterList['co2'], static fn( string $input ): bool => $input[$iteration] === $keep );
        $iteration++;
    }

    print_r( [
        'gamma'       => $p1['gamma'],
        'gamma dec'   => bindec( $p1['gamma'] ),
        'epsilon'     => $p1['epsilon'],
        'epsilon dec' => bindec( $p1['epsilon'] ),
        'power'       => bindec( $p1['epsilon'] ) * bindec( $p1['gamma'] )
    ] );

    print_r( [
        'o2'           => current( $filterList['o2'] ),
        'o2 dec'       => bindec( current( $filterList['o2'] ) ?: ''  ),
        'co2'          => current( $filterList['co2'] ),
        'co2 dec'      => bindec( current( $filterList['co2'] ) ?: ''  ),
        'life support' => bindec( current( $filterList['co2'] ) ?: ''  ) * bindec( current( $filterList['o2'] ) ?: '' ),
    ] );
