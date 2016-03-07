<?php

namespace Dummy;

class Token
{
    /**
     * @var Api
     */ 
    private $api;

    /**
     * @var string
     */
    private $cacheKey;

    /**
     * @var
     */
    private $token;

    /**
     * Token constructor.
     * @param Api $api
     */
    public function __construct(Api $api)
    {
        $this->api      = $api;
        $this->cacheKey = sha1($this->api->config->get('api.key'));
        $this->token    = $this->api->config->get('api.token'); 
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function get()
    {
        if ($this->token !== null) {
            return $this->token;
        }

        if ($this->api->cache->contains($this->cacheKey)) {
            return $this->token = $this->api->cache->fetch($this->cacheKey);
        }
        
        $config = $this->api->config;
        $client = new \GuzzleHttp\Client([
            'base_uri' => sprintf('%s://%s/', $config->get('api.host.scheme'), $config->get('api.host')),
            'timeout'  => 5,
            'headers'  => [
                'Content-Type'  => 'application/json',
                'Authorization' => sprintf('Bearer %s', $this->api->config->get('api.key')),
            ],
        ]);

        $response = $client->get('users/session/new');
        $response = json_decode($response->getBody(), true);
        $this->set(isset($response['data']['token']) ? $response['data']['token'] : '');

        if (isset($response['data']['message'])) {
            throw new \Exception($response['data']['message'], $response['data']['code']);
        }

        return $this->token;
    }

    /**
     * @param $token
     * @return $this
     */
    public function set($token)
    {
        $this->token = $token;
        if (empty($token)) {
            $this->api->cache->delete($this->cacheKey);
        } else {
            $this->api->cache->save($this->cacheKey, $token, $this->api->config->get('cache.duration'));
        }
        return $this;
    }
}