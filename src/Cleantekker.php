<?php

namespace Cleantekker;

use Cleantekker\Container\Builder;

class Cleantekker
{
    use ObjectTrait, CommonTrait;

    /**
     * Cleantekker constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->setContainer((new Builder($config))->getContainer());
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->getContainer()->get('token');
    }

    /**
     * @return mixed
     */
    public function getEndpoint()
    {
        return $this->getContainer()->get('endpoint');
    }
}