<?php

namespace Cleantekker;

use Cleantekker\Http\Client\AdapterInterface;

trait CommonTrait
{
    /**
     * @param \League\Container\Container $container
     * @return $this
     */
    public function setContainer(\League\Container\Container $container)
    {
        \Cleantekker\Container::set($container);
        return $this;
    }

    /**
     * @return \League\Container\Container $container
     */
    public function getContainer()
    {
        return \Cleantekker\Container::get();
    }

    /**
     * @return mixed
     */
    public function getConfig()
    {
        return $this->getContainer()->get('config');
    }

    /**
     * @return mixed
     */
    public function getHttpAdapter()
    {
        return $this->getContainer()->get(AdapterInterface::class);
    }

    /**
     * @param $method
     * @param $uri
     * @param array $parameters
     * @return mixed
     */
    public function request($method, $uri, array $parameters = [])
    {
        return $this->getHttpAdapter()->request($method, $uri, $parameters);
    }
}