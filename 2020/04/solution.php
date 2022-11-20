<?php

    declare( strict_types = 1 );

    namespace year2020\day4;

    return static function ( string $input): array {

        $input = explode( "\n\n", $input);

        [$validCount, $part2ValidCount] = [0,0];

        foreach( $input as $passportData ) {

            $passportData = str_replace("\n", " ", $passportData);
            $passport = [];

            foreach( explode(' ', $passportData) as $field ) {
                $field = explode(":", $field, 2);
                $passport[ $field[0] ] = $field[1];
            }

            if (
                array_key_exists('byr', $passport) &&
                array_key_exists('iyr', $passport) &&
                array_key_exists('eyr', $passport) &&
                array_key_exists('hgt', $passport) &&
                array_key_exists('hcl', $passport) &&
                array_key_exists('ecl', $passport) &&
                array_key_exists('pid', $passport)
            ) {
                $validCount++;

                if (
                    ((int) $passport['byr'] >= 1920 && (int) $passport['byr'] <= 2002) &&
                    ((int) $passport['iyr'] >= 2010 && (int) $passport['iyr'] <= 2020  ) &&
                    ( (int) $passport['eyr'] >= 2020 && (int) $passport['eyr'] <= 2030 ) &&
                    ( strstr($passport['hgt'], 'cm')  && (int) $passport['hgt'] >= 150 && (int) $passport['hgt'] <= 193 || strstr($passport['hgt'], 'in') && (int) $passport['hgt'] >= 59 && (int) $passport['hgt'] <= 76 ) &&
                    ( preg_match("/^#[0-9a-f]{6}$/m", $passport['hcl']) === 1) &&
                    ( in_array($passport['ecl'], ['amb', 'blu', 'brn', 'gry', 'grn', 'hzl', 'oth']) ) &&
                    ( preg_match('/^[0-9]{9}$/', $passport['pid']) === 1)
                ) {
                    $part2ValidCount++;
                }
            }


        }

        return [
            'part1' => $validCount,
            'part2' => $part2ValidCount,
        ];

    };

