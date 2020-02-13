<?php

namespace JWebb\Unleash\Entities\Api;

use GuzzleHttp\Client;

abstract class AbstractApi
{

    /**
     * Client object
     *
     * @var Client
     */
    protected $client;

    /**
     * Class of the entity.
     *
     * @var string
     */
    protected $class;

    /**
     * The API endpoint for the entity
     *
     * @var string
     */
    protected $endpoint;

    /**
     * The API entity name
     *
     * @var string
     */
    protected $entityName;

    /**
     * The API query parameters
     *
     * @var array
     */
    protected $params;

    /**
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get all of the Entities from the API resource.
     *
     * @return mixed
     * @throws \Exception
     */
    public function all()
    {
        if (!config('unleash.enabled')) {
            return [];
        }

        try {
            $response = $this->client->get($this->getApiEndpoint(), $this->prepareParams());
            $response = json_decode((string)$response->getBody());

            if (property_exists($response, "$this->entityName")) {
                return array_map(function ($object) {
                    return $this->instantiateEntity($object);
                }, $response->{$this->entityName});
            }
        } catch (\InvalidArgumentException $e) {
            return [];
        }

        return [];
    }

    /**
     * Get a specified Entity from the API resource.
     *
     * @param string $name
     * @return mixed
     */
    public function get(string $name)
    {
        if (!config('unleash.enabled')) {
            return [];
        }

        $this->params = ['namePrefix' => $name];

        try {
            $response = $this->client->get($this->getApiEndpoint(), $this->prepareParams());
            $response = json_decode((string)$response->getBody(), true);

            return $this->handleResponse($response);
        } catch (\InvalidArgumentException $e) {
            return [];
        }
    }

    /**
     * Handle API response.
     *
     * When a filter has been applied, we must handle
     * the response differently.
     *
     * @param $response
     * @return array
     */
    public function handleResponse($response)
    {
        if (empty($this->filter)) {
            return $this->instantiateEntity($response);
        }

        return array_map(function ($object) {
            return $this->instantiateEntity($object);
        }, $response->data);
    }

    /**
     * Prepare the params for the request
     *
     * @return array
     */
    public function prepareParams()
    {
        return $this->params;
    }

    /**
     * Instantiate a new entityClass
     *
     * @param $params
     * @return mixed
     */
    public function instantiateEntity($params)
    {
        return new $this->class($params);
    }

    /**
     * Get the API endpoint
     *
     * @return string
     */
    public function getApiEndpoint()
    {
        return $this->endpoint . "/" . $this->entityName;
    }
}