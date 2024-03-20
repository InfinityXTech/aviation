<?php

namespace App\Domain\Entities;

/**
 * Represents an airline entity.
 * This class encapsulates the details of an airline, primarily focusing on its name.
 * It is designed to be immutable to ensure consistency throughout the application.
 */
class Airline
{
    /**
     * Constructs an Airline object with its name.
     * 
     * @param string $name The name of the airline.
     */
    public function __construct(private readonly string $name)
    {
    }

    /**
     * Get the name of the airline.
     * 
     * @return string The name of the airline.
     */
    public function getName(): string
    {
        return $this->name;
    }
}
