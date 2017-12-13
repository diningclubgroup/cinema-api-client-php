<?php

namespace DCG\Cinema\Tests\Unit\Request\Cache;

use DCG\Cinema\Request\Cache\KeyGenerator;
use PHPUnit\Framework\TestCase;

class KeyGeneratorTest extends TestCase
{
    public function testKeyFormat()
    {
        $keyGenerator = new KeyGenerator();
        $result = $keyGenerator->generateKey('functionNameValue', 'pathValue', ['k' => 'v'], [200]);
        $this->assertStringStartsWith('cinema:request:', $result);
        $this->assertRegExp('/^cinema:request:[0-9a-f]+$/', $result);
    }

    public function testGeneratesDifferentKeysForEveryParamChange()
    {
        $keyGenerator = new KeyGenerator();

        $testCases = [
            ['fn', 'p', ['k' => 'v'], [200]],
            ['fn1', 'p', ['k' => 'v'], [200]],
            ['fn', 'p1', ['k' => 'v'], [200]],
            ['fn', 'p', ['k' => 'v1'], [200]],
            ['fn', 'p', ['k1' => 'v'], [200]],
            ['fn', 'p', ['k' => 'v', 'k1' => 'v'], [200]],
            ['fn', 'p', [], [200]],
            ['fn', 'p', ['k' => 'v'], [201]],
            ['fn', 'p', ['k' => 'v'], [200, 201]],
            ['fn', 'p', ['k' => 'v'], []],
        ];

        $results = [];
        foreach ($testCases as $tc) {
            $results[$keyGenerator->generateKey($tc[0], $tc[1], $tc[2], $tc[3])] = true;
        }

        // Make sure we have the same number of unique results as original test cases
        $this->assertCount(count($testCases), $results);
    }

    public function testReorderedArrayParamsGenerateSameKey()
    {
        $keyGenerator = new KeyGenerator();

        $testCases = [
            ['fn', 'p', ['a' => 'z', 'b' => 'z', 'c' => 'z'], [200, 201, 300, 500]],
            ['fn', 'p', ['b' => 'z', 'a' => 'z', 'c' => 'z'], [200, 201, 300, 500]],
            ['fn', 'p', ['c' => 'z', 'b' => 'z', 'a' => 'z'], [200, 201, 300, 500]],
            ['fn', 'p', ['a' => 'z', 'b' => 'z', 'c' => 'z'], [201, 200, 300, 500]],
            ['fn', 'p', ['a' => 'z', 'b' => 'z', 'c' => 'z'], [500, 201, 300, 200]],
            ['fn', 'p', ['a' => 'z', 'b' => 'z', 'c' => 'z'], [500, 300, 200, 201]],
            ['fn', 'p', ['c' => 'z', 'b' => 'z', 'a' => 'z'], [300, 201, 200, 500]],
        ];

        $results = [];
        foreach ($testCases as $tc) {
            $results[$keyGenerator->generateKey($tc[0], $tc[1], $tc[2], $tc[3])] = true;
        }

        // Every request should have generated the same key
        $this->assertCount(1, $results);
    }
}
