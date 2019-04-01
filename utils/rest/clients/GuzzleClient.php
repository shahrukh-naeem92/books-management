<?php

namespace Utils\Rest\Clients;

use GuzzleHttp\Client;

/**
 * Class GuzzleClient
 * @package Utils\Rest\Clients
 */
class GuzzleClient implements ClientInterface
{
    /**
     * @var Client
     */
    private $client;

    /**
     * Sends a curl request of type get to requested url
     *
     * @param string $url
     * @param array $data
     * @param array $headers
     *
     * @return string
     */
    public function get(string $url, array $data = [], array $headers = []) : string
    {
        $client = $this->getClient();
        $response = $client->get($url, ['query' => $data, 'headers' => $headers]);

        return $response->getBody()->getContents();
    }

    /**
     * Sends a curl request of type post to requested url
     *
     * @param string $url
     * @param array $data
     * @param array $headers
     *
     * @return string
     */
    public function post(string $url, array $data = [], array $headers = []) : string
    {
        $client = $this->getClient();
        $response = $client->post($url, ['form_params' => $data, 'headers' => $headers]);

        return $response->getBody()->getContents();
    }


    /**
     * Sends a curl request of type put to requested url
     *
     * @param string $url
     * @param array $data
     * @param array $headers
     *
     * @return string
     */
    public function put(string $url, array $data = [], array $headers = []) : string
    {
        $client = $this->getClient();
        $response = $client->put($url, ['form_params' => $data, 'headers' => $headers]);

        return $response->getBody()->getContents();
    }

    /**
     * Sends a curl request of type delete to requested url
     *
     * @param string $url
     * @param array $data
     * @param array $headers
     *
     * @return string
     */
    public function delete(string $url, array $data = [], array $headers = []) : string
    {
        $client = $this->getClient();
        $response = $client->delete($url, ['query' => $data, 'headers' => $headers]);

        return $response->getBody()->getContents();
    }

    /**
     * @return Client
     */
    public function getClient() : Client
    {
        return $this->client ?: $this->client = new Client();
    }
}