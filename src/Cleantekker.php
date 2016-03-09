<?php

namespace Cleantekker;

use Cleantekker\Container\Builder;

class Cleantekker
{
    use ObjectTrait, CommonTrait;
    
    public function __construct(array $config = [])
    {
        $this->setContainer((new Builder($config))->getContainer());
    }
    
    public function getToken()
    {
        return $this->getContainer()->get('token');
    }
    
    public function getEndpoint()
    {
        return $this->getContainer()->get('endpoint');
    }
}