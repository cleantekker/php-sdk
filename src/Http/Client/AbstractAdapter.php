<?php

namespace Cleantekker\Http\Client;

use GuzzleHttp\Exception\ClientException;
use Cleantekker\Http\Response;

abstract class AbstractAdapter implements AdapterInterface
{
    /**
     * {@inheritDoc}
     */
    abstract public function request($method, $uri, array $parameters = []);
    
    protected function resolveExceptionClass(ClientException $exception)
    {
        $response = $exception->getResponse()->getBody();
        $response = json_decode($response->getContents());

        if ($response === null) {
            return new \Exception($exception->getMessage());
        }

        $message = isset($response->message) ? $response->message : $response;
        return new \Exception($message);
    }
}