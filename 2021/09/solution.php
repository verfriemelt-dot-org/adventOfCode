<?php

    declare( strict_types = 1 );

    $input = explode( "\n", file_get_contents( __DIR__ . '/input' ) ?: '' );
//    $input = explode( "\n", file_get_contents( __DIR__ . '/input.simple' ) ?: '' );

    class Map {

        private array $map = [];

        public function __construct( array $input ) {
            foreach ( $input as $line ) {
                $this->map[] = array_map( fn( string $i ): int => (int) $i, str_split( $line ) );
            }
        }

        public function getLowPointsRisk(): int {

            $risk = 0;

            for ( $y = 0; $y < count( $this->map ); $y++ ) {
                for ( $x = 0; $x < count( $this->map[$y] ); $x++ ) {

                    $value = $this->getValue( $x, $y );

                    if ( !$this->isLowPoint( $x, $y ) || $value === null ) {
                        continue;
                    }

                    $risk += $value + 1;
                }
            }

            return $risk;
        }

        public function getValue( int $x, int $y ): ?int {
            return $this->map[$y][$x] ?? null;
        }

        public function isLowPoint( int $x, int $y ): bool {


            $value          = $this->getValue( $x, $y );
            $adjacentValues = [];

            $adjacentValues[] = $this->getValue( $x - 1, $y );
            $adjacentValues[] = $this->getValue( $x, $y - 1 );
            $adjacentValues[] = $this->getValue( $x, $y + 1 );
            $adjacentValues[] = $this->getValue( $x + 1, $y );

            return $value < min( ... array_filter( $adjacentValues, fn( null | int $i ): bool => !is_null( $i ) ) );
        }

    }

    $map = new Map( $input );

    print_r( [
        "risk" => $map->getLowPointsRisk()
    ] );

