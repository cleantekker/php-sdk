<?php

namespace Cleantekker\Http\Client;

use Exception;
use GuzzleHttp\Exception\ClientException;
use Cleantekker\Http\Response;

interface AdapterInterface
{
    /**
     * Sends a HTTP request using `$method` to the given `$uri`, with
     * `$parameters` if provided.
     *
     * Use this method as a convenient way of making requests with built-in
     * exception-handling.
     *
     * @param  string $method
     * @param  string $uri
     * @param  array $parameters
     *
     * @return Response
     *
     * @throws ClientException
     * @throws Exception If an invalid HTTP method is specified
     */
    public function request($method, $uri, array $parameters = []);
}