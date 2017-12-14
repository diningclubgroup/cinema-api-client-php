<?php

namespace DCG\Cinema\Request;

class ClientResponse
{
    private $meta;
    private $data;

    /**
     * @param array $meta
     * @param array $data
     */
    public function __construct(array $meta, array $data)
    {
        $this->meta = $meta;
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getMeta(): array
    {
        return $this->meta;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }
}
