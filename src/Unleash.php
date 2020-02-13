<?php

namespace JWebb\Unleash;

use GuzzleHttp\Client;
use JWebb\Unleash\Entities\Api\Feature;

class Unleash
{
    public $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function setClient($client)
    {
        $this->client = $client;
    }

    /**
     * @return Feature
     */
    public function feature()
    {
        return new Feature($this->client);
    }
}
