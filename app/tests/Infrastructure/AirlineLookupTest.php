<?php

namespace App\Tests\Infrastructure;

use App\Infrastructure\AirlineLookup;
use PHPUnit\Framework\TestCase;

/**
 * Class AirlineLookupTest
 * 
 * Test cases for the AirlineLookup class.
 */
class AirlineLookupTest extends TestCase
{
    /**
     * Test that an exception is thrown when no mapping is found for a registration.
     */
    public function testLookupThrowsExceptionWhenNoMapping(): void
    {
        $this->expectException(\RuntimeException::class);

        // Attempt to lookup an unknown registration
        AirlineLookup::from('unknown');
    }

    /**
     * Test that the correct airline name is retrieved from a registration.
     */
    public function testLookupFromRegistration(): void
    {
        // Assert that the correct airline name is retrieved for a known registration
        $this->assertSame('Alpha Airlines', AirlineLookup::from('HA-AAC'));
    }
}
