<?php

namespace Dummy\Http\Client;

use GuzzleHttp\Exception\ClientException;
use Dummy\Http\Response;

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