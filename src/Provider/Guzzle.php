<?php

namespace Dummy\Provider;

use GuzzleHttp\Client;
use Dummy\Http\Client\AdapterInterface;
use Dummy\Http\Client\GuzzleAdapter;
use League\Container\Argument\RawArgument;
use League\Container\ServiceProvider\AbstractServiceProvider;

class Guzzle extends AbstractServiceProvider
{
    /**
     * The provides array is a way to let the container
     * know that a service is provided by this service
     * provider. Every service that is registered via
     * this service provider must have an alias added
     * to this array or it will be ignored.
     *
     * @var array
     */
    protected $provides = [
        AdapterInterface::class,
    ];

    /**
     * Use the register method to register items with the container via the
     * protected $this->container property or the `getContainer` method
     * from the ContainerAwareTrait.
     *
     * @return void
     */
    public function register()
    {
        $container = $this->getContainer();
        $config    = $container->get('config');
        
        $args = [
            'base_uri' => sprintf('%s://%s/%s/', $config->get('scheme'), $config->get('host'), $config->get('version')),
        ];
        if ($config->get('token') != "") {
            $args['headers'] = [
                'Authorization' => sprintf('Bearer %s', $config->get('token')),
            ];
        }
        $container->share(Client::class)->withArgument(new RawArgument($args));
        
        $container->share(AdapterInterface::class, function () use ($container) {
            return new GuzzleAdapter($container->get(Client::class));
        });
    }
}