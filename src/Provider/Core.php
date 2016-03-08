<?php

namespace Cleantekker\Provider;

use League\Container\ServiceProvider\AbstractServiceProvider;

class Core extends AbstractServiceProvider
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
        'endpoint',
        'token',
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
        $container->add('endpoint', function() use ($container) {
            return new \Cleantekker\Endpoint($container);
        });
        $container->add('token', function() use ($container) {
            return new \Cleantekker\Token($container);
        });
    }
}