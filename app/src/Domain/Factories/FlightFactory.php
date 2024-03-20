<?php

namespace App\Domain\Factories;

use App\Domain\Entities\Airline;
use App\Domain\Entities\Airplane;
use App\Domain\Entities\Flight;
use App\Infrastructure\AirlineLookup;
use Exception;
use DateTimeImmutable;

/**
 * Factory class responsible for creating Flight objects from JSON data.
 * This class demonstrates the Factory design pattern, which is used to encapsulate the logic
 * of creating complex objects.
 */
class FlightFactory
{
    /**
     * Creates a Flight object from a JSON string.
     *
     * This method decodes the provided JSON string into an associative array, then utilizes this data
     * to construct and return a Flight object. It demonstrates the use of static factory methods,
     * allowing for direct invocation without creating an instance of the factory.
     *
     * @param string $json The JSON string containing the flight data.
     * @return Flight The constructed Flight object, fully initialized with the decoded data.
     * @throws Exception If the JSON is invalid, cannot be decoded, or is missing required fields.
     */
    public static function createFromJson(string $json): Flight
    {
        // Decode the JSON string into an associative array.
        $data = json_decode($json, true);

        // Check for JSON decoding errors.
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("Invalid JSON provided to " . __METHOD__);
        }

        // Use the AirlineLookup service to resolve the airline name based on registration.
        // This assumes AirlineLookup::from() returns a string; adjust as needed for your implementation.
        $airlineName = AirlineLookup::from($data['registration']);

        // Create an Airline object. This placeholder should be replaced with actual logic
        // to obtain an Airline object, possibly involving more sophisticated lookup or creation logic.
        $airline = new Airline($airlineName);

        // Create an Airplane object with the obtained airline and registration.
        // Adjust according to your domain model's requirements.
        $airplane = new Airplane($data['registration'], $airline);

        // Create and return a new Flight object using the data extracted from JSON.
        // DateTimeImmutable is used for date fields to ensure immutability of the Flight object's state.
        return new Flight(
            $airplane,
            $data['from'],
            $data['to'],
            new DateTimeImmutable($data['scheduled_start']),
            new DateTimeImmutable($data['scheduled_end']),
            new DateTimeImmutable($data['actual_start']),
            new DateTimeImmutable($data['actual_end'])
        );
    }
}
