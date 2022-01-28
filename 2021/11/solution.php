<?php

    declare( strict_types = 1 );

    namespace year2021\day11;

$input = explode( "\n", file_get_contents( __DIR__ . '/input' ) ?: '' );
//    $input = explode( "\n", file_get_contents( __DIR__ . '/input.simple' ) ?: '' );

    class Point {

        public int $x;

        public int $y;

        public int $value;

        public bool $visited = false;

        public function __construct( int $x, int $y, int $value ) {
            $this->x     = $x;
            $this->y     = $y;
            $this->value = $value;
        }

    }

    class Map {

        /**
         * @var Point[]
         */
        private array $points = [];

        private int $maxX;

        /**
         *
         * @param string[] $input
         */
        public function __construct( array $input ) {

            $x = 0;
            $y = 0;

            foreach ( $input as $line ) {
                $this->maxX   = strlen( $line );
                $x            = 0;
                $this->points = [
                    ... $this->points,
                    ... array_map( function ( string $value ) use ( &$x, $y ): Point {
                        return (new Point( $x++, $y, (int) $value ) );
                    }, str_split( $line ) )
                ];
                $y++;
            }
        }

        public function getPoint( int $x, int $y ): ?Point {

            $offset = $this->maxX * $y + $x;
            $point  = $this->points[$offset] ?? null;

            if ( $point === null ) {
                return null;
            }

            if ( $point->x !== $x || $point->y !== $y ) {
                return null;
            }

            return $point;
        }

        /**
         *
         * @param Point $point
         * @return Point[]
         */
        public function getNeighbouringPoints( Point $point ): array {

            return array_filter( [
                $this->getPoint( $point->x + 1, $point->y + 1 ),
                $this->getPoint( $point->x + 1, $point->y + 0 ),
                $this->getPoint( $point->x + 1, $point->y - 1 ),
                $this->getPoint( $point->x + 0, $point->y + 1 ),
                $this->getPoint( $point->x + 0, $point->y - 1 ),
                $this->getPoint( $point->x - 1, $point->y + 1 ),
                $this->getPoint( $point->x - 1, $point->y + 0 ),
                $this->getPoint( $point->x - 1, $point->y - 1 ),
                ] );
        }

        public function print() {

            $x = 0;
            foreach ( $this->points as $p ) {

                echo $p->value;

                if ( ++$x >= $this->maxX ) {
                    echo PHP_EOL;
                    $x = 0;
                }
            }
        }

        public function step(): int {

            foreach ( $this->points as $p ) {
                $p->value++;
            }

            $flashCount = 0;

            while ( count( $flasher = array_filter( $this->points, fn( Point $p ) => !$p->visited && $p->value > 9 ) ) ) {

                foreach ( $flasher as $p ) {
                    $p->visited = true;
                    $p->value   = 0;
                    $flashCount++;
                    foreach ( $this->getNeighbouringPoints( $p ) as $p2 ) {
                        if ( $p2->visited ) {
                            continue;
                        }
                        $p2->value++;
                    }
                }
            }

            foreach ( $this->points as $p ) {
                $p->visited = false;
            }

            return $flashCount;
        }

    }

    $start = microtime( true );

    $map = new Map( $input );

    $c = 0;
    $sync=0;

    for( $i = 0; $i<10000;$i++) {

        $flashes = $map->step();

        if ( $i<100) {
            $c+=$flashes;
        }

        if ($flashes === 100 ) {
            $sync = $i+1;
            break;
        }
    }



    print_r( [
        "time" => microtime( true ) - $start,
        "count" => $c,
        "syncedt" => $sync
    ] );

