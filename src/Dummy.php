<?php

namespace Dummy;

use League\Container\Container;
use Dummy\Container\Builder;

class Dummy
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
    
    public function endpoint($name = null, array $params = [])
    {
        $endpoint = $this->getContainer()->get('endpoint');
        if ($name) {
            return call_user_func_array(array($endpoint, $name), $params);
        }
        return $endpoint;
    }
}