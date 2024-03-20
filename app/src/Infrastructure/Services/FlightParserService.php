<?php

namespace App\Infrastructure\Services;

use App\Domain\Factories\FlightFactory;
use App\Domain\Entities\Flight;

/**
 * Service for parsing flights from a JSON Lines file.
 */
class FlightParserService implements FlightParserInterface
{
    /**
     * Parses flights from a JSON Lines file.
     * 
     * @param string $filePath Path to the JSON Lines file.
     * @param int $limit Number of lines/objects to return (0 for all).
     * @return Flight[] Array of Flight objects.
     * @throws \RuntimeException If the file cannot be found or opened.
     */
    public function parseFlights(string $filePath, int $limit = 0): array
    {
        $flights = [];

        // Check if the file exists
        if (!file_exists($filePath)) {
            throw new \RuntimeException("File not found: $filePath");
        }

        // Open the file for reading
        $handle = fopen($filePath, "r");
        if (!$handle) {
            throw new \RuntimeException("Unable to open file: $filePath");
        }

        // Read each line from the file
        $count = 0;
        while (($line = fgets($handle)) !== false && ($limit === 0 || $count < $limit)) {
            // Parse each line into a Flight object using the FlightFactory
            $flight = FlightFactory::createFromJson($line);
            $flights[] = $flight;
            $count++;

            if ($limit > 0 && $count >= $limit) {
                break; // Stop reading if the limit is reached
            }
        }

        // Close the file handle
        fclose($handle);

        return $flights;
    }
}
