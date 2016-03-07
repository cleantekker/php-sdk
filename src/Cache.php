<?php

namespace Dummy;

class Cache
{
    /** 
     * @var Api
     */
    private $api;

    /**
     * @var
     */
    private $cacheProvider;

    /**
     * Cache constructor.
     * @param Api $api
     */
    public function __construct(Api $api)
    {
        $this->api = $api;
    }

    /**
     * @return \Doctrine\Common\Cache\FilesystemCache
     */
    public function getCacheProvider()
    {
        if ($this->cacheProvider !== null) {
            return $this->cacheProvider;
        }
        $config = $this->api->config;
        if (!$config->get('cache.path') || !file_exists($config->get('cache.path')) || !is_writable($config->get('cache.path'))) {
            return $this->cacheProvider = new \Doctrine\Common\Cache\ArrayCache();
        }
        return $this->cacheProvider = new \Doctrine\Common\Cache\FilesystemCache($config->get('cache.path'));
    }

    /**
     * @param \Doctrine\Common\Cache\CacheProvider|null $cacheProvider
     * @return $this
     */
    public function setCacheProvider(\Doctrine\Common\Cache\CacheProvider $cacheProvider = null)
    {
        $this->cacheProvider = $cacheProvider;
        return $this;
    }

    /**
     * @param $method
     * @param $args
     * @return mixed
     */
    public function __call($method, $args)
    {
        return call_user_func_array([$this->getCacheProvider(), $method], $args);
    }
}