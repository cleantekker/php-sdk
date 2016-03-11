<?php

namespace Cleantekker;

use Cleantekker\Http\Client\AdapterInterface;
use League\Container\Container;

trait CommonTrait
{
    /**
     * @var
     */
    protected $container;

    /**
     * @param Container $container
     * @return $this
     */
    public function setContainer(Container $container)
    {
        $this->container = $container;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getContainer()
    {
        return $this->container;
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