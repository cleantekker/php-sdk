<?php

namespace Dummy;

class Client 
{ 
    /**
     * @var Api
     */
    private $api;

    /**
     * @var
     */
    private $httpClient;

    /**
     * Client constructor.
     * @param Api $api
     */
    public function __construct(Api $api)
    {
        $this->api = $api;
    }

    /**
     * @return \GuzzleHttp\Client
     */
    public function getHttpClient()
    {
        if ($this->httpClient !== null) {
            return $this->httpClient;
        }
        
        return $this->httpClient = new \GuzzleHttp\Client([
            'base_uri' => $this->api->config->getApiUrl(),
            'timeout'  => 5,
            'headers'  => [
                'Content-Type'  => 'application/json',
                'Authorization' => sprintf('Bearer %s', (string)$this->api->token->get()),
            ],
        ]);
    }

    /**
     * @param \GuzzleHttp\Client|null $httpClient
     * @return $this
     */
    public function setHttpClient(\GuzzleHttp\Client $httpClient = null)
    {
        $this->httpClient = $httpClient;
        return $this;
    }

    /**
     * @param array $promises
     * @return mixed 
     */
    public function promiseUnwrap(array $promises = [])
    {
        return \GuzzleHttp\Promise\unwrap($promises);
    }

    /**
     * @param $method
     * @param $args
     * @return mixed
     */
    public function __call($method, $args)
    {
        return call_user_func_array([$this->getHttpClient(), $method], $args);
    }
}