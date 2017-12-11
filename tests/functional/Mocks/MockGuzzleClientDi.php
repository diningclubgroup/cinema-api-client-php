<?php

namespace Tests\Functional\Mocks;

use DCG\Cinema\Di;

class MockGuzzleClientDi extends Di
{
    public static function buildMockDi(
        MockSession $mockSession,
        MockGuzzleClientFactory $mockGuzzleClientFactory = null
    ) {
        return new Di($mockSession, $mockGuzzleClientFactory);
    }
}
