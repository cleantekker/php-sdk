<?php

namespace Dummy;

class Config 
{
    /** 
     * @var array
     */
    private $params = [
        'api.host'        => 'api.dummy.com',
        'api.host.scheme' => 'https',
        'api.version'     => 'v1',
        'api.key'         => '',
        'api.token'       => null,
        'cache.path'      => '/tmp/',
        'cache.duration'  => 3600,
    ];

    /**
     * Config constructor.
     * @param array $params
     */
    public function __construct(array $params = [])
    {
        $this->setParams($params);
    }

    /**
     * @param array $params
     * @return $this
     */
    public function setParams(array $params = [])
    {
        foreach ($params as $key => $value) {
            $this->params[$key] = $value;
        }
        return $this;
    }

    /**
     * @param $key
     * @param null $default
     * @return null
     */
    public function get($key, $default = null)
    {
        return isset($this->params[$key]) || array_key_exists($key, $this->params) ? $this->params[$key] : $default;
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function set($key, $value)
    {
        $this->params[$key] = $value;
        return $this;
    }

    /**
     * @param string $append
     * @return string
     */
    public function getApiUrl($append = '')
    {
        return sprintf('%s://%s/%s/%s', $this->get('api.host.scheme'), $this->get('api.host'), $this->get('api.version'), $append);
    }
}