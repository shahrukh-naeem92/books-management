<?php

namespace Utils\Rest\Clients;

/**
 * Interface ClientInterface
 * @package Utils\Rest\Clients
 */
interface ClientInterface
{

    /**
     * @param string $url
     * @param array $data
     * @param array $headers
     *
     * @return string
     */
    public function get(string $url, array $data, array $headers) : string;

    /**
     * @param string $url
     * @param array $data
     * @param array $headers
     *
     * @return string
     */
    public function post(string $url, array $data, array $headers) : string;

    /**
     * @param string $url
     * @param array $data
     * @param array $headers
     *
     * @return string
     */
    public function delete(string $url, array $data, array $headers) : string;

    /**
     * @param string $url
     * @param array $data
     * @param array $headers
     *
     * @return string
     */
    public function put(string $url, array $data, array $headers) : string;
}