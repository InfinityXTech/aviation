<?php

namespace App\Infrastructure\Services;

/**
 * Interface for parsing airports.
 * This interface defines a method for parsing airports, optionally filtering by IATA codes.
 */
interface AirportParserInterface {
    /**
     * Parse airports, optionally filtered by IATA codes.
     *
     * @param array $byIata An optional array of IATA codes to filter the airports.
     * @return array An array of parsed airports.
     */
    public function parseAirports(array $byIata = []): array;
}
