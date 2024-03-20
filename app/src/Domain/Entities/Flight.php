<?php

namespace App\Domain\Entities;

/**
 * Represents a flight entity.
 * This class encapsulates the details of a flight, including the airplane used,
 * departure and arrival locations, scheduled and actual start and end times.
 * It is designed to be immutable to ensure consistency throughout the application.
 */
class Flight
{
    /**
     * Constructs a Flight object with its details.
     * 
     * @param Airplane $airplane The airplane used for the flight.
     * @param string $from The departure location of the flight.
     * @param string $to The arrival location of the flight.
     * @param \DateTimeImmutable $scheduledStart The scheduled start time of the flight.
     * @param \DateTimeImmutable $scheduledEnd The scheduled end time of the flight.
     * @param \DateTimeImmutable $actualStart The actual start time of the flight.
     * @param \DateTimeImmutable $actualEnd The actual end time of the flight.
     */
    public function __construct(
        private readonly Airplane $airplane,
        private readonly string $from,
        private readonly string $to,
        private readonly \DateTimeImmutable $scheduledStart,
        private readonly \DateTimeImmutable $scheduledEnd,
        private readonly \DateTimeImmutable $actualStart,
        private readonly \DateTimeImmutable $actualEnd,
    )
    {
    }

    /**
     * Get the airplane used for the flight.
     * 
     * @return Airplane The airplane object representing the airplane used for the flight.
     */
    public function getAirplane(): Airplane
    {
        return $this->airplane;
    }

    /**
     * Get the departure location of the flight.
     * 
     * @return string The departure location of the flight.
     */
    public function getFrom(): string
    {
        return $this->from;
    }

    /**
     * Get the arrival location of the flight.
     * 
     * @return string The arrival location of the flight.
     */
    public function getTo(): string
    {
        return $this->to;
    }

    /**
     * Get the scheduled start time of the flight.
     * 
     * @return \DateTimeImmutable The scheduled start time of the flight.
     */
    public function getScheduledStart(): \DateTimeImmutable
    {
        return $this->scheduledStart;
    }

    /**
     * Get the scheduled end time of the flight.
     * 
     * @return \DateTimeImmutable The scheduled end time of the flight.
     */
    public function getScheduledEnd(): \DateTimeImmutable
    {
        return $this->scheduledEnd;
    }

    /**
     * Get the actual start time of the flight.
     * 
     * @return \DateTimeImmutable The actual start time of the flight.
     */
    public function getActualStart(): \DateTimeImmutable
    {
        return $this->actualStart;
    }

    /**
     * Get the actual end time of the flight.
     * 
     * @return \DateTimeImmutable The actual end time of the flight.
     */
    public function getActualEnd(): \DateTimeImmutable
    {
        return $this->actualEnd;
    }
}
