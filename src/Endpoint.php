<?php

namespace Cleantekker;

use League\Container\Container;

class Endpoint
{
    /**
     * Object setters and getters
     */
    use ObjectTrait;

    /**
     * @var Container
     */
    private $container;

    /**
     * Endpoint constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @return mixed|object
     */
    public function getJobs()
    {
        return $this->container->get('entity.job');
    }

    /**
     * @return mixed|object
     */
    public function getJobsTypes()
    {
        return $this->container->get('entity.jobsTypes');
    }

    /**
     * @return mixed|object
     */
    public function getJobsCategories()
    {
        return $this->container->get('entity.jobsCategories');
    }
}