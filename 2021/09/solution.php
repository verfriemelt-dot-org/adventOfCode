<?php

    declare( strict_types = 1 );

    namespace year2021\day9;

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

        public function getLowPointsRisk(): int {

            $risk = 0;

            foreach ( $this->getLowPoints() as $point ) {
                $risk += $point->value + 1;
            }

            return $risk;
        }

        /**
         *
         * @return Point[]
         */
        public function getLowPoints(): array {

            $points = [];

            foreach ( $this->points as $point ) {

                if ( !$this->isLowPoint( $point ) ) {
                    continue;
                }

                $points[] = $point;
            }

            return $points;
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
                $this->getPoint( $point->x + 1, $point->y + 0 ),
                $this->getPoint( $point->x + 0, $point->y + 1 ),
                $this->getPoint( $point->x - 1, $point->y - 0 ),
                $this->getPoint( $point->x - 0, $point->y - 1 ),
                ] );
        }

        public function isLowPoint( Point $point ): bool {

            $adjacentValues = array_map( static fn( Point $p ): int => $p->value, $this->getNeighbouringPoints( $point ) );

            return $point->value < min( ... $adjacentValues );
        }

        /**
         * @return array<array{'lowpoint': Point, 'size': int }>
         */
        public function getBasins(): array {

            $basins = [];

            foreach ( $this->getLowPoints() as $lowPoint ) {

                $points    = [];
                $newPoints = [ $lowPoint ];

                while ( count( $newPoints ) > 0 ) {

                    $new = [];

                    foreach ( $newPoints as $point ) {

                        if ( $point->visited ) {
                            continue;
                        }

                        $point->visited = true;
                        $points[]   = $point;
                        $new        = [
                            ... $new,
                            ... array_filter( $this->getNeighbouringPoints( $point ), static fn( Point $p ) => $p->value !== 9 && !$p->visited ) ];
                    }

                    $newPoints = $new;
                }

                $basins[] = [
                    'lowpoint' => $lowPoint,
                    'size'     => count( $points ),
//                    'points' => array_map(fn(Point $p): array => [$p->x,$p->y, $p->value], $points),
                ];
            }

            return $basins;
        }

    }

    $start = microtime( true );

    $map    = new Map( $input );
    $basins = $map->getBasins();

    usort( $basins, fn( array $a, array $b ) => $b['size'] <=> $a['size'] );

    print_r( [
        "risk"             => $map->getLowPointsRisk(),
        "time"             => microtime( true ) - $start,
//        "basins" => $map->getBasins(),
        "multipliedBasins" => array_reduce( array_slice( $basins, 0, 3 ), fn( int $carry, array $input ) => $carry * $input['size'], 1 )
    ] );

