<?php

namespace App\Infrastructure;

/**
 * Class AirlineLookup
 * 
 * A simple lookup service for mapping airplane registrations to airline names.
 */
class AirlineLookup
{
    /**
     * @var array<string, string> $map An associative array mapping airplane registrations to airline names.
     */
    private static array $map = [
        'HA-AAA' => 'Alpha Airlines',
        'HA-AAB' => 'Alpha Airlines',
        'HA-AAC' => 'Alpha Airlines',

        'D-AAA' => 'Delta Freight',
        'D-AAB' => 'Delta Freight',
        'D-AAC' => 'Delta Freight',

        'OO-AAA' => 'Oscar Air',
        'OO-AAB' => 'Oscar Air',
        'OO-AAC' => 'Oscar Air',
    ];

    /**
     * Retrieves the airline name associated with the given airplane registration.
     *
     * @param string $registration The airplane registration.
     * @return string The airline name.
     * @throws \RuntimeException If the registration mapping is missing.
     */
    public static function from(string $registration): string
    {
        if (array_key_exists($registration, self::$map)) {
            return self::$map[$registration];
        }

        throw new \RuntimeException('Missing registration mapping.');
    }
}
