<?php

namespace App\Infrastructure;

use App\Domain\FlightAnalyzer;
use App\Infrastructure\Services\AirportParserService;
use App\Infrastructure\Services\FlightParserService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'parse')]
class ParseCommand extends Command
{
    /**
     * Executes the command to parse flight data and display analytics.
     *
     * @param InputInterface $input The input interface.
     * @param OutputInterface $output The output interface.
     * @return int The command exit code.
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $flightsParser = new FlightParserService();

        $filePath = __DIR__ . '/../../var/input.jsonl';

        try {
            $flights = $flightsParser->parseFlights($filePath);

            $this->displayLongestFlights($io, $flights);

            $this->displayMissedMostScheduledLandings($io, $flights);

            $this->displayDestinationWithMostOvernightStays($io, $flights);

            $this->displayAllCountries($io, $flights);
            
        } catch (\RuntimeException $e) {
            $io->error($e->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }

    /**
     * Displays the three longest flights.
     *
     * @param SymfonyStyle $io The SymfonyStyle instance.
     * @param array $flights An array of Flight objects.
     */
    protected function displayLongestFlights(SymfonyStyle $io, array $flights): void
    {
        $threeLongestFlights = FlightAnalyzer::longestFlights($flights, 3);

        $flightDetails = array_map(function ($flight, $index) {
            $duration = $flight->getActualEnd()->getTimestamp() - $flight->getActualStart()->getTimestamp();
            return sprintf(
                "%d. Flight from %s to %s, duration: %d minutes",
                $index + 1,
                $flight->getFrom(),
                $flight->getTo(),
                $duration / 60 // Convert seconds to minutes
            );
        }, $threeLongestFlights, array_keys($threeLongestFlights));

        $io->info("Longest flights: ");
        $io->listing($flightDetails);
    }

    /**
     * Displays the airline with the most missed scheduled landings.
     *
     * @param SymfonyStyle $io The SymfonyStyle instance.
     * @param array $flights An array of Flight objects.
     */
    protected function displayMissedMostScheduledLandings(SymfonyStyle $io, array $flights): void
    {
        $airline = FlightAnalyzer::airlineWithMostMissedLandings($flights, 5);

        $io->info("Airline with most missed landings:");
        $io->title($airline?->getName() ?? 'N/A');
    }

    /**
     * Displays the destination with the most overnight stays.
     *
     * @param SymfonyStyle $io The SymfonyStyle instance.
     * @param array $flights An array of Flight objects.
     */
    protected function displayDestinationWithMostOvernightStays(SymfonyStyle $io, array $flights): void
    {
        $destination = FlightAnalyzer::destinationWithMostOvernightStays($flights);

        $io->info("Destination that had the most overnight stays:");
        $io->title($destination ?? 'N/A');
    }

    /**
     * Displays all countries and their radio spellings.
     *
     * @param SymfonyStyle $io The SymfonyStyle instance.
     * @param array $flights An array of Flight objects.
     */
    protected function displayAllCountries(SymfonyStyle $io, array $flights): void
    {
        $airportParser = new AirportParserService();

        $iataCodes = FlightAnalyzer::iataCodes($flights);

        $airports = $airportParser->parseAirports($iataCodes);

        $list = [];
        
        foreach ($airports as $index => $airport) {
            $spelling = FlightAnalyzer::spellUsingPhoneticAlphabet($airport->getIata());

            $list[] = sprintf(
                "%d. %s - %s - %s - (%s)",
                $index + 1,
                $airport->getCountry(),
                $airport->getState(),
                $airport->getName(),
                $spelling
            );
        }

        $io->info("Countries and Radio Spelling:");
        $io->listing($list);
    }
}
