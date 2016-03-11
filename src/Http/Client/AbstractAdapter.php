<?php

namespace Cleantekker\Http\Client;

use GuzzleHttp\Exception\ClientException;
use Cleantekker\ObjectTrait;

abstract class AbstractAdapter implements AdapterInterface
{
    /**
     * Object setters and getters
     */   
    use ObjectTrait;
    
    /**
     * {@inheritDoc}
     */
    abstract public function request($method, $uri, array $parameters = []);

    /**
     * @param $uri
     * @param array $parameters
     * @return \Cleantekker\Http\Response
     */
    public function get($uri, array $parameters = [])
    {
        return $this->request('GET', $uri, $parameters);
    }

    /**
     * @param $uri
     * @param array $parameters
     * @return \Cleantekker\Http\Response
     */
    public function post($uri, array $parameters = [])
    {
        return $this->request('POST', $uri, $parameters);
    }

    /**
     * @param $uri
     * @param array $parameters
     * @return \Cleantekker\Http\Response
     */
    public function put($uri, array $parameters = [])
    {
        return $this->request('PUT', $uri, $parameters);
    }

    /**
     * @param $uri
     * @return \Cleantekker\Http\Response
     */
    public function delete($uri)
    {
        return $this->request('DELETE', $uri);
    }

    /**
     * @param ClientException $exception
     * @return \Exception
     */
    protected function resolveExceptionClass(ClientException $exception)
    {
        $response = $exception->getResponse()->getBody();
        $response = json_decode($response->getContents());

        if ($response === null) {
            return new \Exception($exception->getMessage());
        }
        if (!empty($response->message)) {
            $message = (string)$response->message;
        } elseif (!empty($response->errors)) {
            $message = $response->errors;
            if (is_array($response->errors)) {
                $message = [];
                foreach ($response->errors as $error) {
                    $message[] = $error->message;
                }
                $message = implode(PHP_EOL, $message);
            }
        } else {
            $message = (string)$response;
        }
        
        return new \Exception($message);
    }
}