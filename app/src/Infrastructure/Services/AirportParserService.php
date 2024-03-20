<?php

namespace App\Infrastructure\Services;

use App\Domain\Entities\AirportInfo;

/**
 * Service for parsing airports from a JSON file.
 */
class AirportParserService implements AirportParserInterface
{
    /**
     * Parses airports from a JSON file.
     * 
     * @param array $byIata An optional array of IATA codes to filter the airports.
     * @return AirportInfo[] Array of AirportInfo objects.
     */
    public function parseAirports(array $byIata = []): array
    {
        $airports = $this->fetchAirportsData();
        $data = [];

        foreach ($airports as $icaoKey => $airport) {
            // Check if the airport should be included based on the filter or if no filter is applied
            if (empty($byIata) || (in_array($airport['iata'], $byIata) && !empty($airport['iata']))) {
                $data[] = new AirportInfo(
                    $airport['icao'],
                    $airport['iata'],
                    $airport['name'],
                    $airport['city'],
                    $airport['state'],
                    $airport['country'],
                    $airport['elevation'],
                    $airport['lat'],
                    $airport['lon'],
                    $airport['tz']
                );
            }
        }

        return $data;
    }

    /**
     * Fetches airports data from a remote JSON file.
     * 
     * @return array The decoded JSON data containing airport information.
     */
    public function fetchAirportsData(): array
    {
        $url = "https://raw.githubusercontent.com/soixt/AirportsData/master/airports.json";
        $json = file_get_contents($url);
        $data = json_decode($json, true);
        return $data;
    }
}
