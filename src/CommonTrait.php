<?php

namespace Dummy;

use Dummy\Http\Client\AdapterInterface;
use League\Container\Container;

trait CommonTrait
{
    protected $container;
    
    public function setContainer(Container $container)
    {
        $this->container = $container;
        return $this;
    }
    
    public function getContainer()
    {
        return $this->container;
    }
    
    public function getConfig()
    {
        return $this->getContainer()->get('config');
    }

    public function getHttpAdapter()
    {
        return $this->getContainer()->get(AdapterInterface::class);
    }

    public function request($method, $uri, array $parameters = [])
    {
        return $this->getHttpAdapter()->request($method, $uri, $parameters);
    }
}