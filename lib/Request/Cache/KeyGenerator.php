<?php

namespace DCG\Cinema\Request\Cache;

class KeyGenerator
{
    const CACHE_PREFIX = 'cinema:request:';

    /**
     * @param string $functionName
     * @param string $path
     * @param array $queryParams
     * @param array $successStatusCodes
     * @return string
     */
    public function generateKey(
        string $functionName,
        string $path,
        array $queryParams,
        array $successStatusCodes
    ): string
    {
        ksort($queryParams);
        sort($successStatusCodes);

        $hashSegments = [
            $functionName,
            $path,
            implode(':', array_keys($queryParams)),
            implode(':', $queryParams),
            implode(':', $successStatusCodes),
        ];

        return self::CACHE_PREFIX . sha1(implode('|', $hashSegments));
    }
}
