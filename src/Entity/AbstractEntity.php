<?php

namespace Cleantekker\Entity;

use Cleantekker\ObjectTrait;
use Cleantekker\Http\Client\AdapterInterface;

abstract class AbstractEntity
{
    /**
     * Object setters and getters
     */
    use ObjectTrait;

    /**
     * @var Container
     */
    protected $container;
    
    /**
     * @var AdapterInterface
     */
    protected $client;
    
    /**
     * @var array
     */
    protected $params = [];
    
    /**
     * @var array
     */
    protected $initialObjectVars = [];

    /**
     * @var
     */
    public $basePath = '';
    
    /**
     * Creates a new instance of `Adapter`.
     *
     * @param AdapterInterface $client
     */
    public function __construct(AdapterInterface $client)
    {
        $this->client            = $client;
        $this->initialObjectVars = array_keys(get_object_vars($this));
        $this->params['itemEnvelope'] = get_class($this);
    }
    
    /**
     * @param array $params
     * @return \Cleantekker\Http\Response
     */
    public function all(array $params = [])
    {
        return $this->client->get($this->basePath, array_merge($this->params, $params));
    }

    /**
     * @param $id
     * @param array $params
     * @return \Cleantekker\Http\Response
     */
    public function one($id, array $params = [])
    {
        return $this->client->get($this->basePath . '/' . $id, array_merge($this->params, $params));
    }

    /**
     * @return \Cleantekker\Http\Response
     */
    public function save()
    {
        if (empty($this->id)) {
            return $this->create();
        }
        return $this->update();
    }

    /**
     * @param array $params
     * @return \Cleantekker\Http\Response
     */
    public function create(array $params = [])
    {
        if (empty($params)) {
            $params = $this->getAttributes();
        }
        return $this->client->post($this->basePath, array_merge($this->params, [
            'json' => $params
        ]));
    }

    /**
     * @param $id
     * @param array $params
     * @return \Cleantekker\Http\Response
     */
    public function update($id = null, array $params = [])
    {
        if (empty($id) && empty($params)) {
            $params = $this->getAttributes();
            $id     = $this->id;
        }
        return $this->client->put($this->basePath . '/' . $id, array_merge($this->params, [
            'json' => $params
        ]));
    }

    /**
     * @param $id
     * @return \Cleantekker\Http\Response
     */
    public function delete($id = null)
    {
        if (empty($id) && !empty($this->id)) {
            $id = $this->id;
        }
        return $this->client->delete($this->basePath . '/' . $id);
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        $vars = array_diff(array_keys(get_object_vars($this)), $this->initialObjectVars);
        $attr = [];
        foreach ($vars as $var) {
            $attr[$var] = $this->$var;
        }
        return $attr;
    }
    
    /**
     * @param array $attributes
     * @return $this
     */
    public function setAttributes(array $attributes = [])
    {
        $attrs = array_diff(array_keys($attributes), $this->initialObjectVars);
        foreach ($attrs as $key) {
            $this->$key = $attributes[$key];
        }
        return $this;
    }

    /**
     * @param $name
     * @return mixed
     * @throws \Exception
     * @throws \Exception
     */
    public function __get($name)
    {
        $getter = 'get' . $name;
        if (method_exists($this, $getter)) {
            return $this->$getter();
        } else {
            throw new \Exception('Getting unknown property: ' . get_class($this) . '::' . $name);
        }
    }

    /**
     * @param $name
     * @param $value
     * @throws \Exception
     */
    public function __set($name, $value)
    {
        $setter = 'set' . $name;
        if (method_exists($this, $setter)) {
            $this->$setter($value);
        } else {
            $this->$name = $value;
        }
    }
}