<?php

namespace App\Domain;

use App\Domain\Entities\Airline;
use App\Domain\Entities\Flight;

class FlightAnalyzer
{
    /**
     * Returns the three longest flights based on actual duration.
     *
     * @param Flight[] $flights Array of Flight objects to analyze.
     * @param int $limit Number of longest flights to return.
     * @return Flight[] The three longest flights.
     */
    public static function longestFlights(array $flights, int $limit): array
    {
        usort($flights, function ($a, $b) {
            $durationA = $a->getActualEnd()->getTimestamp() - $a->getActualStart()->getTimestamp();
            $durationB = $b->getActualEnd()->getTimestamp() - $b->getActualStart()->getTimestamp();

            return $durationB <=> $durationA;
        });

        return array_slice($flights, 0, $limit);
    }

    /**
     * Identifies the airline with the most flights that missed their scheduled landings by more than a given threshold.
     *
     * @param Flight[] $flights Array of Flight objects to analyze.
     * @param int $minutes Threshold in minutes for considering a landing as missed.
     * @return Airline|null The Airline object with the most missed landings, or null if none.
     */
    public static function airlineWithMostMissedLandings(array $flights, int $minutes = 5): ?Airline
    {
        $missedLandingsCount = [];
        $airlines = [];

        foreach ($flights as $flight) {
            $airline = $flight->getAirplane()->getAirline();
            $airlineName = $airline->getName();

            $scheduledEnd = $flight->getScheduledEnd()->getTimestamp();
            $actualEnd = $flight->getActualEnd()->getTimestamp();

            if (($actualEnd - $scheduledEnd) > ($minutes * 60)) {
                if (!isset($missedLandingsCount[$airlineName])) {
                    $missedLandingsCount[$airlineName] = 1;
                    $airlines[$airlineName] = $airline;
                } else {
                    $missedLandingsCount[$airlineName]++;
                }
            }
        }

        if (empty($missedLandingsCount)) {
            return null;
        }

        $maxMisses = max($missedLandingsCount);
        $airlineWithMostMissesIdentifier = array_search($maxMisses, $missedLandingsCount);

        return $airlines[$airlineWithMostMissesIdentifier] ?? null;
    }

    /**
     * Determines which destination had the most overnight stays.
     *
     * @param Flight[] $flights Array of Flight objects to analyze.
     * @return string|null The destination (airport code) with the most overnight stays, or null if none.
     */
    public static function destinationWithMostOvernightStays(array $flights): ?string
    {
        $overnightStaysCount = [];

        foreach ($flights as $flight) {
            $destination = $flight->getTo();
            $scheduledStart = $flight->getScheduledStart();
            $scheduledEnd = $flight->getScheduledEnd();

            if ($scheduledEnd->format('Y-m-d') != $scheduledStart->format('Y-m-d')) {
                if (!isset($overnightStaysCount[$destination])) {
                    $overnightStaysCount[$destination] = 1;
                } else {
                    $overnightStaysCount[$destination]++;
                }
            }
        }

        $maxStays = 0;
        $destinationWithMostStays = null;
        foreach ($overnightStaysCount as $destination => $count) {
            if ($count > $maxStays) {
                $maxStays = $count;
                $destinationWithMostStays = $destination;
            }
        }

        return $destinationWithMostStays;
    }

    /**
     * Spell out a given string using the NATO phonetic alphabet.
     *
     * @param string $string The string to spell out.
     * @return string The spelled out string using the phonetic alphabet.
     */
    public static function spellUsingPhoneticAlphabet(string $string): string
    {
        $phoneticAlphabet = [
            'A' => 'Alpha', 'B' => 'Bravo', 'C' => 'Charlie', 'D' => 'Delta', 'E' => 'Echo',
            'F' => 'Foxtrot', 'G' => 'Golf', 'H' => 'Hotel', 'I' => 'India', 'J' => 'Juliett',
            'K' => 'Kilo', 'L' => 'Lima', 'M' => 'Mike', 'N' => 'November', 'O' => 'Oscar',
            'P' => 'Papa', 'Q' => 'Quebec', 'R' => 'Romeo', 'S' => 'Sierra', 'T' => 'Tango',
            'U' => 'Uniform', 'V' => 'Victor', 'W' => 'Whiskey', 'X' => 'X-ray', 'Y' => 'Yankee', 'Z' => 'Zulu'
        ];

        $spelledOut = '';
        foreach (str_split(strtoupper($string)) as $letter) {
            $spelledOut .= $phoneticAlphabet[$letter] . ' ' ?? $letter . ' ';
        }

        return trim($spelledOut);
    }

    /**
     * Get unique IATA codes from a list of flights.
     *
     * @param Flight[] $flights Array of Flight objects to extract IATA codes from.
     * @return array Unique IATA codes.
     */
    public static function iataCodes(array $flights): array
    {
        $allLocations = [];

        foreach ($flights as $flight) {
            $allLocations[] = $flight->getFrom();
            $allLocations[] = $flight->getTo();
        }

        $uniqueLocations = array_unique($allLocations);

        return array_values($uniqueLocations);
    }
}
