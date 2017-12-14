<?php

namespace DCG\Cinema\Request;

use DCG\Cinema\Exception\UnexpectedStatusCodeException;
use GuzzleHttp\ClientInterface as GuzzleClientInterface;

class RequestSender
{
    /**
     * @param GuzzleClientInterface $guzzleClient
     * @param string $type
     * @param string $path
     * @param array $queryParams
     * @param string|null $body
     * @param int[] $successStatusCodes
     * @return ClientResponse
     * @throws \Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sendRequest(
        GuzzleClientInterface $guzzleClient,
        string $type,
        string $path,
        array $queryParams,
        string $body = null,
        array $successStatusCodes
    ): ClientResponse
    {
        $options = [];
        if ($body !== null) {
            $options['body'] = $body;
        }

        $queryString = '';
        if ($queryParams) {
            $queryString .= '?' . http_build_query($queryParams);
        }

        $response = $guzzleClient->request($type, $path . $queryString, $options);

        if (!in_array($response->getStatusCode(), $successStatusCodes)) {
            throw new UnexpectedStatusCodeException($response->getStatusCode());
        }

        $content = json_decode((string)$response->getBody(), true);

        return new ClientResponse(
            isset($content['meta']) ? $content['meta'] : [],
            isset($content['data']) ? $content['data'] : []
        );
    }
}
