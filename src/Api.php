<?php 

namespace Dummy;

class Api 
{ 
    /**
     * @var array
     */
    private $map = [];

    /**
     * @var array
     */
    private $instances = [];
    
    /**
     * Api constructor.
     * @param array $params
     */
    public function __construct(array $params = [])
    {
        $this->setClassMap();
        $this->config->setParams($params);
    }
    
    private function setClassMap()
    {
        $this->map = [
            'config'    => [Config::class],
            'client'    => [Client::class, $this],
            'cache'     => [Cache::class, $this],
            'token'     => [Token::class, $this],
        ];
        return $this;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        if (isset($this->map[$name])) {
            if (!isset($this->instances[$name])) {
                $className = array_shift($this->map[$name]);
                $this->instances[$name] = (new $className(...$this->map[$name]));
                array_unshift($this->map[$name], $className);
            }
            return $this->instances[$name];
        }
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        if (isset($this->map[$name])) {
            $this->instances[$name] = $value;
        } 
    }
}