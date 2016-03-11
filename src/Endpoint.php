<?php

namespace Cleantekker;

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
     */
    public function __construct()
    {
        $this->container = Container::get();
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