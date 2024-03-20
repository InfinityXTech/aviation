<?php

namespace App\Domain\Entities;

/**
 * Represents detailed information about an airport.
 * This class encapsulates various attributes of an airport, ensuring a comprehensive 
 * representation that includes identification codes, location details, geographical data,
 * and timezone information. It is designed to be immutable to guarantee the consistency 
 * of airport information throughout the application's lifecycle.
 */
class AirportInfo {
    /**
     * Constructs an AirportInfo object with all necessary details.
     * 
     * @param string $icao International Civil Aviation Organization airport code.
     * @param string $iata International Air Transport Association airport code.
     * @param string $name The official name of the airport.
     * @param string $city The city where the airport is located.
     * @param string $state The state or region where the airport is located.
     * @param string $country The country where the airport is located.
     * @param int $elevation The elevation of the airport above sea level in meters.
     * @param float $lat The latitude of the airport's location.
     * @param float $lon The longitude of the airport's location.
     * @param string $tz The timezone of the airport, represented as a string.
     */
    public function __construct(
        private readonly string $icao,
        private readonly string  $iata,
        private readonly string $name,
        private readonly string $city,
        private readonly string $state,
        private readonly string $country,
        private readonly int $elevation,
        private readonly float $lat,
        private readonly float $lon,
        private readonly string $tz
    ) {}

    /**
     * Get the ICAO code of the airport.
     *
     * @return string
     */
    public function getIcao(): string {
        return $this->icao;
    }

    /**
     * Get the IATA code of the airport.
     *
     * @return string
     */
    public function getIata(): string {
        return $this->iata;
    }

    /**
     * Get the name of the airport.
     *
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * Get the city where the airport is located.
     *
     * @return string
     */
    public function getCity(): string {
        return $this->city;
    }

    /**
     * Get the state where the airport is located.
     *
     * @return string
     */
    public function getState(): string {
        return $this->state;
    }

    /**
     * Get the country where the airport is located.
     *
     * @return string
     */
    public function getCountry(): string {
        return $this->country;
    }

    /**
     * Get the elevation of the airport in meters.
     *
     * @return int
     */
    public function getElevation(): int {
        return $this->elevation;
    }

    /**
     * Get the latitude of the airport's location.
     *
     * @return float
     */
    public function getLat(): float {
        return $this->lat;
    }

    /**
     * Get the longitude of the airport's location.
     *
     * @return float
     */
    public function getLon(): float {
        return $this->lon;
    }

    /**
     * Get the timezone of the airport.
     *
     * @return string
     */
    public function getTimezone(): string {
        return $this->tz;
    }
}
