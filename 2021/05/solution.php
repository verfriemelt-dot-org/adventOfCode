<?php

    declare( strict_types = 1 );

    namespace year2021\day5;

$input = explode( "\n", file_get_contents( __DIR__ . '/input' ) ?: '' );

//    $input = explode( "\n", file_get_contents( __DIR__ . '/input.simple' ) ?: '' );

    class Point {

        public int $x;

        public int $y;

        public function __construct( int $x, int $y ) {
            $this->x = $x;
            $this->y = $y;
        }

    }

    class Line {

        public Point $from;

        public Point $to;

        public function __construct( Point $from, Point $to ) {
            $this->from = $from;
            $this->to   = $to;
        }

        public function isDiagonal(): bool {
            return $this->from->x !== $this->to->x && $this->from->y !== $this->to->y;
        }

        /**
         *
         * @return Point[]
         */
        public function getPointsCovered(): array {

            if ( !$this->isDiagonal() ) {
                return $this->getOrthogonalPoints();
            } else {
                return $this->getDiagonalPoints();
            }
        }

        /**
         *
         * @return Point[]
         */
        private function getDiagonalPoints(): array {
            $direction = $this->from->x == $this->to->x ? "y" : "x";

            $x = range( $this->from->x, $this->to->x );
            $y = range( $this->from->y, $this->to->y );

            $points = [];

            for ( $i = 0; $i < count( $x ); $i++ ) {
                $points[] = new Point( $x[$i], $y[$i] );
            }

            return $points;
        }

        /**
         *
         * @return Point[]
         */
        private function getOrthogonalPoints(): array {

            $direction = $this->from->x === $this->to->x ? "y" : "x";

            $points = [ $this->from, $this->to ];

            for (
                /** @phpstan-ignore-next-line */
                $step = min( $this->from->{$direction}, $this->to->{$direction} ) + 1;
                /** @phpstan-ignore-next-line */
                $step < max( $this->from->{$direction}, $this->to->{$direction} );
                $step++
            ) {
                $point = new Point( $this->from->x, $this->from->y );

                /** @phpstan-ignore-next-line */
                $point->{$direction} = $step;
                $points[]            = $point;
            }

            return $points;
        }

    }

    class Plane {

        /**
         * @var Line[]
         */
        public array $lines = [];

        private Point $bottomRight;

        public function __construct() {
            $this->bottomRight = new Point( 0, 0 );
        }

        public function addLine( Line $line ): void {
            $this->lines[] = $line;

            $this->bottomRight->x = max( $this->bottomRight->x, $line->from->x, $line->to->x );
            $this->bottomRight->y = max( $this->bottomRight->y, $line->from->y, $line->to->y );
        }

        /**
         * @return array<int, array<int, int>>
         */
        public function getCounts(): array {
            $count = array_fill( 0, $this->bottomRight->x + 1, array_fill( 0, $this->bottomRight->y + 1, 0 ) );

            foreach ( $this->lines as $line ) {

                foreach ( $line->getPointsCovered() as $point ) {
                    $count[$point->x][$point->y]++;
                }
            }

            return $count;
        }

    }

    $p1Plane = new Plane();
    $p2Plane = new Plane();

    foreach ( $input as $line ) {

        [$from, $to] = array_map(
            fn( $raw ): Point => new Point( ... array_map( fn( $i ) => (int) $i, explode( ',', $raw ) ) ),
            explode( ' -> ', $line )
        );

        $line = new Line( $from, $to );

        $p2Plane->addLine( $line );
        if ( $line->isDiagonal() ) {
            continue;
        }
        $p1Plane->addLine( $line );
    }
    print_r( [
//        "count" => array_filter( ), fn( $i ) => $i > 1)
        "p1 count" => array_reduce(
            $p1Plane->getCounts(),
            fn( int $carry, array $i ): int => $carry + count( array_filter( $i, fn( int $n ) => $n > 1 ) ),
            0
        ),
        "p2 count" => array_reduce(
            $p2Plane->getCounts(),
            fn( int $carry, array $i ): int => $carry + count( array_filter( $i, fn( int $n ) => $n > 1 ) ),
            0
        )
    ] );

