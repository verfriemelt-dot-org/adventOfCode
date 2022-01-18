<?php

    [$numbers, $fields] = explode( "\n\n", file_get_contents( __DIR__ . '/input' ) ?: '', 2 );
//    [$numbers, $fields] = explode( "\n\n", file_get_contents( __DIR__ . '/input.simple' ) ?: '', 2 );

    $numbers = array_map( fn( $i ) => (int) $i, explode( ',', $numbers ) );
    $fields  = explode( "\n\n", $fields );

    class Bingo {

        private array $field;

        private array $marked;

        public function __construct( string $input ) {

            $result = [];

            if ( !preg_match_all( '~([0-9]+)~', $input, $result ) ) {
                throw new RuntimeException( 'illegal input' );
            }

            $this->field  = array_map( fn( $i ) => (int) $i, $result[0] );
            $this->marked = array_fill( 0, count( $this->field ), false );

            if ( count( array_unique( $this->field ) ) !== count( $this->field ) ) {
                throw new RuntimeException( 'dup vars' );
            }
        }

        public function mark( int $number ): void {

            $toMark = array_search( $number, $this->field, true );

            if ( $toMark === false ) {
                return;
            }

            $this->marked[$toMark] = true;
        }

        public function check(): bool {

            // hori
            $step = (int) sqrt( count( $this->field ) );
            for ( $offset = 0; $offset + $step <= count( $this->field ); $offset += $step ) {
                $slice = array_slice( $this->marked, $offset, $step );

                if ( count( array_filter( $slice ) ) === count( $slice ) ) {
                    return true;
                }
            }

            // vert
            for ( $i = 0; $i < count( $this->field ); $i++ ) {

                $line = [];

                for ( $offset = $i; $offset <= count( $this->field ); $offset += $step ) {
                    $line[] = $this->marked[$offset];
                }

                if ( (int) count( array_filter( $line ) ) === $step ) {
                    return true;
                }
            }

            return false;
        }

        public function getScore( int $lastNumber ): int {
            $sum = 0;
            foreach ( $this->field as $pos => $number ) {
                if ( !$this->marked[$pos] ) {
                    $sum += $number;
                }
            }

            return $sum * $lastNumber;
        }

        public function print(): void {

            $step = 5;
            $count = 1;
            foreach( $this->field as $index => $number ) {

                if ( $this->marked[$index ]  ) {
                    echo "\033[31m";
                } else {
                    echo "\033[37m";
                }
                echo str_pad( $number, 3, ' ', STR_PAD_LEFT);
                echo "\033[0m";
                if ( $count % $step === 0 ) {
                    echo PHP_EOL;
                }

                $count++;
            }
        }
    }

    $bingos = [];

    // init bingos
    foreach ( $fields as $field ) {
        $bingos[] = new Bingo( $field );
    }

    // go through numbers
    foreach ( $numbers as $number ) {
//        print_r( $number . PHP_EOL );
        foreach ( $bingos as $index => $bingo ) {

            $bingo->mark( $number );

            if ( $bingo->check() ) {

                print_r( [
                    "bingo",
                    "number" => $number,
                    "score"  => $bingo->getScore( $number )
                ] );

                $bingo->print();

                // remove board
                unset( $bingos[$index] );
                print_r(['board_count' => count( $bingos )]);

            }
        }
    }

