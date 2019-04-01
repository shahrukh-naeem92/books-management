<?php

namespace Utils\Api;

use Utils\Rest\Clients\ClientInterface;
use Utils\Rest\Clients\ClientFactory;

/**
 * Class IceAndFireApi
 * @package Utils\Api
 */
class IceAndFireApi
{
    /**
     * Api url
     */
    const URL = 'https://www.anapioficeandfire.com/api/books';

    /**
     * @var ClientInterface
     */
    private $restClient;

    /**
     * @var ClientInterface
     */
    private $restClientType;

    public function __construct($type = 'GuzzleClient')
    {
        $this->restClientType = $type;
    }

    /**
     * Request the books from ice and fire api
     *
     * @param string $name
     *
     * @throws \Exception
     *
     * @return array
     */
    public function getBooks(string $name) : array
    {
        $restClient = $this->getRestClient();

        return json_decode($restClient->get(self::URL, ['name' => $name]), true);
    }

    /**
     * Get rest client of specified type for curl calls
     *
     * @throws \Exception
     *
     * @return ClientInterface
     */
    private function getRestClient() : ClientInterface
    {
        return $this->restClient ?: $this->restClient = ClientFactory::create($this->restClientType);
    }

}