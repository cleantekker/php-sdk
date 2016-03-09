<?php

namespace Cleantekker\Entity;

use Cleantekker\Http\Client\AdapterInterface;
use Cleantekker\ObjectTrait;

abstract class AbstractEntity
{
    /**
     * Object setters and getters
     */
    use ObjectTrait;
    
    /**
     * @var AdapterInterface
     */
    protected $client;

    /**
     * Creates a new instance of `Adapter`.
     *
     * @param AdapterInterface $client
     */
    public function __construct(AdapterInterface $client)
    {
        $this->client = $client;
    }
}