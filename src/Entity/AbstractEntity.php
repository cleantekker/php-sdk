<?php

namespace Dummy\Entity;

use Dummy\Http\Client\AdapterInterface;

abstract class AbstractEntity
{
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