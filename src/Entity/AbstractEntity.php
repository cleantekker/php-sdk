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
     * @var string
     */
    public $basePath = '';

    /**
     * Creates a new instance of `Adapter`.
     *
     * @param AdapterInterface $client
     */
    public function __construct(AdapterInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param array $params
     * @return \Cleantekker\Http\Response
     */
    public function all(array $params = [])
    {
        return $this->client->request('GET', $this->basePath, $params);
    }

    /**
     * @param $id
     * @param array $params
     * @return \Cleantekker\Http\Response
     */
    public function one($id, array $params = [])
    {
        return $this->client->request('GET', $this->basePath . '/' . $id, $params);
    }

    /**
     * @param array $params
     * @return \Cleantekker\Http\Response
     */
    public function create(array $params = [])
    {
        return $this->client->request('POST', $this->basePath, [
            'json' => $params
        ]);
    }

    /**
     * @param $id
     * @param array $params
     * @return \Cleantekker\Http\Response
     */
    public function update($id, array $params = [])
    {
        return $this->client->request('PUT', $this->basePath . '/' . $id, [
            'json' => $params
        ]);
    }

    /**
     * @param $id
     * @return \Cleantekker\Http\Response
     */
    public function delete($id)
    {
        return $this->client->request('DELETE', $this->basePath . '/' . $id);
    }
}