<?php

namespace DCG\Cinema\Request\Cache;

class KeyGenerator
{
    const CACHE_PREFIX = 'cinema:request:';

    /**
     * @param $functionName
     * @param $path
     * @param $queryParams
     * @param $successStatusCodes
     * @return string
     */
    public function generateKey($functionName, $path, $queryParams, $successStatusCodes)
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
