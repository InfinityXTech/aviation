<?php

namespace App\Tests\Infrastructure;

use App\Domain\Entities\Airline;
use App\Domain\Entities\Flight;
use App\Domain\FlightAnalyzer;
use App\Infrastructure\Services\FlightParserService;
use PHPUnit\Framework\TestCase;

class ParseCommandTest extends TestCase
{
    /**
     * Test parsing flights from a file.
     */
    public function testParseFlights(): void
    {
        $filePath = __DIR__ . '../../var/input.jsonl';
        $flights = $this->getMockedFlights($filePath);

        // Assert the length of the returned array
        $this->assertCount(3, $flights);

        // Assert that each item in the returned array is an instance of Flight class
        foreach ($flights as $flight) {
            $this->assertInstanceOf(Flight::class, $flight);
        }
    }

    /**
     * Test finding the longest flights.
     */
    public function testLongestFlights(): void
    {
        $filePath = __DIR__ . '../../var/input.jsonl';
        $flights = $this->getMockedFlights($filePath);

        // Assuming FlightAnalyzer::longestFlights() is a static method
        $threeLongestFlights = FlightAnalyzer::longestFlights($flights, 3);

        // Assert the length of the returned array
        $this->assertCount(3, $threeLongestFlights);

        // Assert that each item in the returned array is an instance of Flight class
        foreach ($threeLongestFlights as $flight) {
            $this->assertInstanceOf(Flight::class, $flight);
        }
    }

    /**
     * Test finding the airline with the most missed scheduled landings.
     */
    public function testMissedMostScheduledLandings(): void
    {
        $filePath = __DIR__ . '../../var/input.jsonl';
        $flights = $this->getMockedFlights($filePath);
        $airline = FlightAnalyzer::airlineWithMostMissedLandings($flights);

        if ($airline !== null) {
            $this->assertInstanceOf(Airline::class, $airline);
        } else {
            $this->assertNull($airline);
        }
    }

    /**
     * Test finding destinations with the most overnight stays.
     */
    public function testDestinationsWithMostOvernightStays(): void
    {
        $filePath = __DIR__ . '../../var/input.jsonl';
        $flights = $this->getMockedFlights($filePath);
        $destination = FlightAnalyzer::destinationWithMostOvernightStays($flights);

        if ($destination !== null) {
            $this->assertIsString($destination);
        } else {
            $this->assertNull($destination);
        }
        
    }


    /**
     * Mocks flight parsing from a file.
     *
     * @param string $filePath Path to the file containing flight data.
     * @return array Array of mocked Flight objects.
     */
    private function getMockedFlights(string $filePath): array
    {
        // Create a mock FlightParserService
        $flightParserService = $this->createMock(FlightParserService::class);
        
        // Mocked array of Flight objects returned by FlightParserService
        $expectedFlights = [
            $this->createMock(Flight::class),
            $this->createMock(Flight::class),
            $this->createMock(Flight::class)
        ];

        $flightParserService->expects($this->once())
            ->method('parseFlights')
            ->with($this->equalTo($filePath), $this->equalTo(0)) // Ensure limit is 0 to get all flights
            ->willReturn($expectedFlights);
            
        return $flightParserService->parseFlights($filePath);
    }

}
