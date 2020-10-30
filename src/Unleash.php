<?php

namespace JWebb\Unleash;

use GuzzleHttp\Client;
use JWebb\Unleash\Entities\Api\Feature;

class Unleash
{
    /**
     * @var Client
     */
    public Client $client;

    /**
     * Unleash constructor.
     * @param  Client  $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param Client $client
     */
    public function setClient(Client $client)
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
