<?php

declare( strict_types = 1 );

namespace year2020\day7;

use function array_count_values;
use function array_keys;
use function explode;
use function in_array;
use function preg_match_all;
use function str_split;
use function str_starts_with;
use const PREG_SET_ORDER;

return static function ( string $input ): array {

    $input = explode( "\n", $input );

    [ $part1, $part2 ] = [ null, null ];

    $bags = [];

    foreach($input as $bag) {

        if ( preg_match('/^(?<bag>.+?) bags contain (?<rest>.*).$/', $bag, $match) !== 1) {
            throw new \RuntimeException();
        }

        if (str_starts_with(trim($match['rest']), 'contain no other bags')) {
            $bags[$match['bag']] = [];
            continue;
        }

        preg_match_all('/(?<amount>[0-9])+ (?<subs>[a-z]+ [a-z]+)[\.,]*/',$match['rest'],$sub, PREG_SET_ORDER);

        $subBags = [];

        foreach( $sub as $s ) {
            $subBags[$s['subs']] = $s['amount'];
        }

        $bags[$match['bag']] = $subBags;
    }


    // shiny bag inside other bags
    $optionsCount = 0;
    $options = ['shiny gold'];

    while(count($options) !== $optionsCount) {

        $optionsCount = count($options);

        foreach($options as $option) {
            foreach($bags as $name => $contents) {
                if ( in_array($option, array_keys($contents)) && !in_array($name,$options)) {
                    $options[] = $name;
                }
            }
        }
    }

//    // shiny bag contains other bags
//    $bagCount = 0;
//    $options = ['shiny gold'];
//
//    while(count($options) !== $optionsCount) {
//
//        $optionsCount = count($options);
//
//        foreach($options as $option) {
//            foreach($bags as $name => $contents) {
//                if ( in_array($option, array_keys($contents)) && !in_array($name,$options)) {
//                    $options[] = $name;
//                }
//            }
//        }
//    }

    return [
        // amount of options without the shiny bag itself
        'part1' => count($options) - 1,
        'part2' => 1,
    ];
};

