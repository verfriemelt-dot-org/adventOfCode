<?php

    declare( strict_types = 1 );

    $input = explode( ",", file_get_contents( __DIR__ . '/input' ) ?: '' );
//    $input = explode( ",", file_get_contents( __DIR__ . '/input.simple' ) ?: '' );

    $fish = array_map( fn(string $i ): int => (int ) $i, $input );

    $day = 0;


    print_r( ['day' => 'initial', "fish" => implode(', ', $fish)  ]);

    while( ++$day <= 80  ) {

        $newCount = count(array_filter($fish, fn ( int $i) => $i === 0 ));


        $fish = array_map( fn(int $i):int => $i === 0 ? 6 : --$i, $fish);
        $fish = [
            ... $fish,
            ... array_fill(0, $newCount, 8),
        ];
        print_r([
            "dayt" => $day,
            "fish" => implode(', ', $fish),
            "fishCount" => count($fish),
            "newCount" => $newCount,

        ]);



    }