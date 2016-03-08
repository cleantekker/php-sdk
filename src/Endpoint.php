<?php

namespace Cleantekker;

use League\Container\Container;

class Endpoint
{
    private $container;
    
    public function __construct(Container $container)
    {
        $this->container = $container;
    }
    
    public function jobs()
    {
        return $this->container->get('entity.job');
    }
}