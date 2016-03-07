<?php

namespace Dummy;

class BasicAuth
{
    /**
     * @var Api
     */
    private $api;

    /**
     * Token constructor.
     * @param Api $api
     */
    public function __construct(Api $api)
    {
        $this->api = $api;
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function auth($username, $password)
    {
        $config = $this->api->config;
        $client = new \GuzzleHttp\Client([
            'base_uri' => sprintf('%s://%s/', $config->get('api.host.scheme'), $config->get('api.host')),
            'timeout'  => 5,
            'auth'  => [
                'username' => $username,
                'password' => $password,
            ],
        ]);

        $response = $client->get('users/session/new');
        $response = json_decode($response->getBody(), true);
   
        if (isset($response['data']['message'])) {
            throw new \Exception($response['data']['message'], $response['data']['code']);
        }

        $this->api->token->set($response['data']['token']);
        
        return true;
    }
}