<?php

namespace Cleantekker;

use Cleantekker\Container\Builder;

class Cleantekker
{
    use CommonTrait;
    
    public function __construct(array $config = [])
    {
        $this->setContainer((new Builder($config))->getContainer());
    }
    
    public function token()
    {
        return $this->getContainer()->get('token');
    }
    
    public function endpoint()
    {
        return $this->getContainer()->get('endpoint');
    }
}