<?php

namespace Cleantekker;

use League\Container\Container;

class Token
{
    use ObjectTrait, CommonTrait;

    /**
     * Token constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->setContainer($container);
    }

    /**
     * @return mixed
     */
    public function get()
    {
        return $this->getConfig()->get('token');
    }

    /**
     * @param $token
     * @return $this
     */
    public function set($token)
    {
        $this->getConfig()->set('token', $token);
        $this->getHttpAdapter()->setHeader('Authorization', sprintf('Bearer %s', $token));
        return $this;
    }

    /**
     * @param null $key
     * @return mixed
     */
    public function getFromApiKey($key = null)
    {
        $config = $this->getConfig();
        if ($key === null) {
            $key = $config->get('key');
        }
        $response = $this->request('GET', 'users/session/new', [
            'base_uri' => sprintf('%s://%s/', $config->get('scheme'), $config->get('host')),
            'headers'  => [
                'Authorization' => sprintf('Bearer %s', $key)
            ],
        ]);
        return $response->get()['token'];
    }

    /**
     * @return mixed
     */
    public function getNew()
    {
        $config   = $this->getConfig();
        $response = $this->request('GET', 'users/session/renew', [
            'base_uri' => sprintf('%s://%s/', $config->get('scheme'), $config->get('host')),
            'headers'  => [
                'Authorization' => sprintf('Bearer %s', $this->get())
            ],
        ]);
        return $response->get()['token'];
    }

    /**
     * @return mixed
     */
    public function refresh()
    {
        $token = $this->getNew();
        $this->set($token);
        return $token;
    }
}