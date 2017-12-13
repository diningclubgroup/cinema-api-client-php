<?php

namespace DCG\Cinema\Tests\Unit\Request\Cache;

use DCG\Cinema\Request\Cache\LifetimeGenerator;
use PHPUnit\Framework\TestCase;

class LifetimeGeneratorTest extends TestCase
{
    public function testGeneratesValuesInSpecifiedRange()
    {
        $lifetimeGenerator = new LifetimeGenerator(10, 12);

        // Map of value to count
        $results = [];

        // Run 1000 times to ensure we get a range of values
        for ($i = 0; $i < 1000; $i++) {
            $lifetime = $lifetimeGenerator->generateLifetimeSeconds();
            if (!array_key_exists($lifetime, $results)) {
                $results[$lifetime] = 0;
            }
            $results[$lifetime]++;
        }

        // Ensure no values have been generated that fall outside the expected range
        $this->assertCount(3, $results);

        // Ensure that every valid value has been generated at least once
        $this->assertArrayHasKey(10, $results);
        $this->assertArrayHasKey(11, $results);
        $this->assertArrayHasKey(12, $results);
    }

    public function testThrowsOnInvalidConfiguration()
    {
        $this->expectException(\RuntimeException::class);
        new LifetimeGenerator(10, 9);
    }
}
