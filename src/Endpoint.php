<?php

namespace Dummy;

class Endpoint
{
    private $container;
    
    public function __construct($container)
    {
        $this->container = $container;
    }
    
    public function jobs()
    {
        return $this->container->get('entity.job');
    }
}