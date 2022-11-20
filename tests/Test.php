<?php

use PHPUnit\Framework\TestCase;

class Test
    extends TestCase
{

    private const SOLUTION_FILE = 'solution.php';
    private const SOLUTION_OUTPUT = 'solution';

    private function finder(): Generator
    {

        foreach ( glob( __DIR__ . '/../202*/*' ) as $path ) {

            if ( str_starts_with( '.', $path ) ) {
                continue;
            }

            $year = basename(dirname($path));
            $day = basename( $path );

            yield sprintf( "%s.%s", $year, $day ) => [ 'path' => $path ];
        }
    }

    /**
     * @dataProvider finder
     */
    public function test( string $path ): void
    {
        static::assertFileExists( "{$path}/" . static::SOLUTION_FILE, 'solution file must be exsting' );


        $callable = require_once "{$path}/" . static::SOLUTION_FILE;

        if ( !is_callable($callable)) {
            $this->markTestSkipped('not implemented');
        }

        static::assertIsCallable($callable);

        foreach(['simple','full'] as $complexity) {

            static::assertFileExists( "{$path}/input.{$complexity}", 'input file must be exsting' );

            $input = trim(file_get_contents( "{$path}/input.{$complexity}"));
            static::assertIsString($input);

            $result = $callable($input);

            static::assertIsArray($result);
            static::assertArrayHasKey('part1', $result);
            static::assertArrayHasKey('part2', $result);

            foreach( ['part1', 'part2'] as $part ) {

                $output = file_get_contents( "{$path}/solution.{$part}.$complexity" );

                if ( $result[$part] === null ) {
                    continue;
                }

                self::assertSame(
                    trim( $output ),
                    trim( $result[$part] ),
                    "validate «{$complexity}» solution for {$part}"
                );
            }
        }
    }
}
