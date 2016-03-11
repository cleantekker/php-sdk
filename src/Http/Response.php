<?php

namespace Cleantekker\Http;

use Illuminate\Support\Collection;
use Cleantekker\ObjectTrait;
use Cleantekker\Http\Client\AdapterInterface;
use Cleantekker\Container;

class Response
{
    /**
     * Object setters and getters
     */
    use ObjectTrait;
    
    /**
     * @var array
     */
    protected $raw;

    /**
     * @var array
     */
    protected $data;
    
    /**
     * @var array
     */
    protected $meta;
    
    /**
     * @var array
     */
    protected $links;
    
    /**
     * @var
     */
    protected $itemEnvelope;

    /**
     * Creates a new instance of `Response`.
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->data  = isset($data['data']) && is_array($data['data']) ? $data['data'] : [];
        $this->meta  = isset($data['meta']) && is_array($data['meta']) ? $data['meta'] : [];
        $this->links = isset($data['links']) && is_array($data['links']) ? $data['links'] : [];
        $this->raw = [
            'data'  => $this->data,
            'meta'  => $this->meta,
            'links' => $this->links,
        ];
        
        $this->itemEnvelope = isset($data['itemEnvelope']) ? $data['itemEnvelope'] : [];
    }

    /**
     * Creates a new instance of `Response` from a JSON-decoded response body.
     *
     * @param array $response
     * 
     * @return static
     */
    public static function createFromJson(array $response = [])
    {
        return new static([
            'data'         => array_key_exists('data', $response)  ? $response['data']  : [],
            'meta'         => array_key_exists('meta', $response)  ? $response['meta']  : [],
            'links'        => array_key_exists('links', $response) ? $response['links'] : [],
            'itemEnvelope' => array_key_exists('itemEnvelope', $response) ? $response['itemEnvelope'] : null,
        ]);
    }

    /**
     * Returns JSON-decoded raw response.
     *
     * @return array
     */
    public function getRaw()
    {
        return $this->raw;
    }

    /**
     * Returns `data` from the response.
     *
     * @return array|Collection
     */
    public function get()
    {
        if (empty($this->itemEnvelope)) {
            return $this->isCollection($this->data) ? new Collection($this->data) : $this->data;
        }

        $className = $this->itemEnvelope;
        $client    = Container::get()->get(AdapterInterface::class);
        if ($this->isCollection($this->data)) {
            return new Collection(array_map(function($item) use ($className, $client) {
                return (new $className($client))->configure($item);
            }, $this->data));
        }

        return (new $className($client))->configure($this->data);
    }

    /**
     * Tests the current response data to see if one or more records were
     * returned.
     *
     * @param array|Collection $data
     *
     * @return bool
     */
    protected function isCollection($data)
    {
        $isCollection = false;

        if ($data === null) {
            return $isCollection;
        }

        if (!$this->isRecord($data)) {
            $isCollection = true;
        }

        return $isCollection;
    }

    /**
     * Tests the current response data to see if a single record was returned.
     *
     * @param array|Collection $data
     *
     * @return bool
     */
    protected function isRecord($data)
    {
        if ($data instanceof Collection) {
            return false;
        }

        $keys = array_keys($data);
        return (in_array('id', $keys, true) || in_array('name', $keys, true));
    }

    /**
     * If the response has a `pagination` field with a `next_url` key, then
     * returns `true`, otherwise `false`.
     *
     * @return bool
     */
    public function hasPages()
    {
        return !empty($this->links) && array_key_exists('next', $this->links);
    }

    /**
     * Returns the next URL, if available, otherwise `null`.
     *
     * @return string|null
     */
    public function nextUrl()
    {
        return $this->hasPages() ? $this->links['next'] : null;
    }

    /**
     * Returns the JSON-encoded raw response.
     *
     * @return string
     */
    public function __toString()
    {
        return json_encode($this->getRaw());
    }
}