<?php

namespace DCG\Cinema\Tests\Functional\Mocks;

use DCG\Cinema\Di;

class MockGuzzleClientDi extends Di
{
    public static function buildMockDi(
        MockSession $mockSession,
        MockGuzzleClientFactory $mockGuzzleClientFactory = null,
        MockCache $mockCache = null
    ) {
        if ($mockCache === null) {
            $mockCache = new MockCache();
        }
        return new Di($mockSession, $mockCache, $mockGuzzleClientFactory, 0, 0);
    }
}
