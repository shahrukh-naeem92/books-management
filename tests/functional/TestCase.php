<?php


namespace Tests\Functional;

use Tests\TestCase as ParentTestCase;
use Symfony\Component\HttpFoundation\Response;

class TestCase extends ParentTestCase
{

    /**
     * Make a call to specified url and return response
     *
     * @param string $method
     * @param string $url
     * @param array $data
     *
     * @return Null|Response
     */
    protected function getResponse(string $method, string $url, array $data) : ?Response
    {
        return $this->call($method, $url, $data);
    }

    /**
     * Convert Response object to array
     *
     * @param Response $response
     *
     * @return Null|array
     */
    protected function getResponseContentAsArray(Response $response) : ?array
    {
        return json_decode($response->getContent(), true);
    }
}