<?php

namespace App\Infrastructure\Services;

/**
 * Interface for parsing flights.
 * This interface defines a method for parsing flights from a file.
 */
interface FlightParserInterface {
    /**
     * Parse flights from a file.
     *
     * @param string $filePath The path to the file containing flight data.
     * @return array An array of parsed flights.
     */
    public function parseFlights(string $filePath): array;
}
