<?php

    declare( strict_types = 1 );

    namespace year2021\day12;

$input = explode( "\n", file_get_contents( __DIR__ . '/input' ) ?: '' );

    $input = explode( "\n", file_get_contents( __DIR__ . '/input.simple' ) ?: '' );

    class Cave {

        public bool $isBig;

        public string $ident;

        /**
         * @var Cave[]
         */
        public array $connections = [];

        public function __construct( string $ident ) {
            $this->ident = $ident;
            $this->isBig = ord( $ident[0] ) >= ord( 'a' );
        }

        public function addConnection( Cave $cave ): static {
            $this->connections[] = $cave;
            return $this;
        }

    }

    class Map {

        /**
         * @var Cave[]
         */
        public array $caves = [];

        public function addCave( Cave $cave ): Cave {
            $this->caves [] = $cave;
            return $cave;
        }

        public function getCaveByIdent( string $ident ): ?Cave {
            foreach ( $this->caves as $cave ) {
                if ( $cave->ident === $ident ) {
                    return $cave;
                }
            }

            return null;
        }

    }

    $map = new Map();

    foreach ( $input as $line ) {

        [$a, $b] = explode( '-', $line, 2 );

        $caveA = $map->getCaveByIdent( $a ) ?? $map->addCave( new Cave( $a ) );
        $caveB = $map->getCaveByIdent( $b ) ?? $map->addCave( new Cave( $b ) );

        $caveA->addConnection( $caveB );
        $caveB->addConnection( $caveA );
    }

    $start = microtime( true );

    print_r( [
        "time" => microtime( true ) - $start,
//        "map"  => $map,
    ] );

