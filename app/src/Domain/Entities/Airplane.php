<?php

namespace App\Domain\Entities;

/**
 * Represents an airplane entity.
 * This class encapsulates the details of an airplane, including its registration 
 * and the airline it belongs to.
 * It is designed to be immutable to ensure consistency throughout the application.
 */
class Airplane
{
    /**
     * Constructs an Airplane object with its registration and associated airline.
     * 
     * @param string $registration The registration code of the airplane.
     * @param Airline $airline The airline to which the airplane belongs.
     */
    public function __construct(private readonly string $registration, private readonly Airline $airline)
    {
    }

    /**
     * Get the registration code of the airplane.
     * 
     * @return string The registration code of the airplane.
     */
    public function getRegistration(): string
    {
        return $this->registration;
    }

    /**
     * Get the airline to which the airplane belongs.
     * 
     * @return Airline The airline object representing the airline of the airplane.
     */
    public function getAirline(): Airline
    {
        return $this->airline;
    }
}
