<?php

namespace Cleantekker\Provider;

use Cleantekker\ObjectTrait;
use Cleantekker\Entity\Job;
use Cleantekker\Entity\JobType;
use Cleantekker\Entity\JobCategory;
use Cleantekker\Http\Client\AdapterInterface;
use League\Container\ServiceProvider\AbstractServiceProvider;

class Entity extends AbstractServiceProvider
{
    /**
     * Object setters and getters
     */
    use ObjectTrait;

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
        'entity.job',
        'entity.jobsTypes',
        'entity.jobsCategories',
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
        $container->share('entity.job', new Job($container->get(AdapterInterface::class)));
        $container->share('entity.jobsTypes', new JobType($container->get(AdapterInterface::class)));
        $container->share('entity.jobsCategories', new JobCategory($container->get(AdapterInterface::class)));
    }
}