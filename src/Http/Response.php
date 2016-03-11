<?php

namespace Cleantekker\Http;

use Illuminate\Support\Collection;
use Cleantekker\ObjectTrait;

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
     * Creates a new instance of `Response`.
     *
     * @param array $data
     * @param array $meta
     * @param array $links
     */
    public function __construct(array $data = [], array $meta = [], array $links = [])
    {
        $this->data  = $data;
        $this->meta  = $meta;
        $this->links = $links;
        $this->raw = [
            'data'  => $data,
            'meta'  => $meta,
            'links' => $links,
        ];
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
        $data  = array_key_exists('data', $response)  ? $response['data']  : [];
        $meta  = array_key_exists('meta', $response)  ? $response['meta']  : [];
        $links = array_key_exists('links', $response) ? $response['links'] : [];

        return new static($data, $meta, $links);
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
        return $this->isCollection($this->data) ? new Collection($this->data) : $this->data;
    }

    /**
     * Merges the contents of this response with `$response` and returns a new
     * `Response` instance.
     *
     * @param Response $response
     *
     * @return Response
     *
     * @throws Exception
     */
    public function merge(Response $response)
    {
        $data  = $response->get();
        $meta  = $response->getRaw()['meta'];
        $links = $response->hasPages() ? $response->getRaw()['links'] : [];

        if ($this->isCollection($this->data) && $this->isCollection($data)) {
            $data = array_flatten([$this->data, $data], 1);
            return new Response($data, $meta, $links);
        }

        if ($this->isRecord($this->data) && $this->isRecord($data)) {
            return new Response($meta, [$this->data, $data], $links);
        }

        throw new Exception('The response contents cannot be merged');
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
        return $this->hasPages() ? $this->pagination['next'] : null;
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