<?php

namespace Cleantekker;

use League\Container\Container;

class Endpoint
{
    /**
     * Object setters and getters
     */
    use ObjectTrait;
    
    private $container;
    
    public function __construct(Container $container)
    {
        $this->container = $container;
    }
    
    public function getJobs()
    {
        return $this->container->get('entity.job');
    }
}