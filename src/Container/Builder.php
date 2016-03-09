<?php

namespace Cleantekker\Container;

use Cleantekker\ObjectTrait;
use Cleantekker\Config;
use Cleantekker\Provider\Core;
use Cleantekker\Provider\Entity;
use Cleantekker\Provider\Guzzle;
use League\Container\Container;
use League\Container\ContainerAwareInterface;
use League\Container\ContainerAwareTrait;
use League\Container\ContainerInterface;
use League\Container\ServiceProvider\ServiceProviderInterface;


class Builder implements ContainerAwareInterface
{
    use ObjectTrait, ContainerAwareTrait;

    /**
     * Default application service providers.
     *
     * @var array
     */
    protected $defaultProviders = [
        Core::class,
        Entity::class,
        Guzzle::class,
    ];

    /**
     * Creates a new instance of `Builder`. If `$registerProviders` is set to
     * `true`, then the default providers are registered onto the container.
     *
     * @param array $config
     * @param bool  $registerProviders
     */
    public function __construct(array $config, $registerProviders = true)
    {
        $this->setContainer($this->createContainer($config));
        $this->createConfig($this->getContainer()->get('config.raw'));
        
        if ($registerProviders) {
            $this->registerProviders($this->defaultProviders);
        }
    }

    /**
     * Creates a `Config` object from raw parameters.
     *
     * @param array $config
     *
     * @return Config
     */
    protected function createConfig(array $config)
    {
        $this->getContainer()->share('config', new Config($config));
    }

    /**
     * Register default service providers onto the container.
     *
     * @param array $providers
     *
     * @return Builder
     */
    public function registerProviders(array $providers = [])
    {
        foreach ($providers as $provider) {
            $this->registerProvider($provider);
        }
        return $this;
    }

    /**
     * Registers a service provider onto the container.
     *
     * @param string|ServiceProviderInterface $provider
     *
     * @return Builder
     */
    public function registerProvider($provider)
    {
        $this->getContainer()->addServiceProvider($provider);
        return $this;
    }

    /**
     * Creates and returns a new instance of `Container` after adding `$config`
     * to it.
     *
     * @param array $config
     *
     * @return ContainerInterface
     */
    public function createContainer(array $config)
    {
        $container = new Container();
        $container->add('config.raw', $config);
        $this->setContainer($container);
        return $this->getContainer();
    }
}