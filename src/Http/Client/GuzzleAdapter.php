<?php

namespace Dummy\Http\Client;

use Exception;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use Dummy\Http\Response;

class GuzzleAdapter extends AbstractAdapter
{
    /**
     * The Guzzle client instance.
     *
     * @var ClientInterface
     */
    protected $guzzle;

    /**
     * @var array
     */
    protected $params = [
        'headers' => [],
    ];
    
    /**
     * Creates a new instance of `GuzzleAdapter`.
     *
     * @param ClientInterface $guzzle
     */
    public function __construct(ClientInterface $guzzle)
    {
        $this->guzzle = $guzzle;
    }

    /**
     * {@inheritDoc}
     */
    public function request($method, $uri, array $parameters = [])
    {
        try {
            $response = $this->guzzle->request($method, $uri, array_merge($this->params, $parameters));

        } catch (ClientException $e) {

            if (!$e->hasResponse()) {
                throw $e;
            }

            throw $this->resolveExceptionClass($e);

        } catch (Exception $e) {
            throw $e;
        }

        return Response::createFromJson(json_decode($response->getBody()->getContents(), true));
    }
    
    public function setHeader($key, $value)
    {
        $this->params['headers'][$key] = $value;
        return $this;
    }
}