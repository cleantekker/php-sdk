<?php

namespace Cleantekker;

use League\Container\Container;

class Endpoint
{
    /**
     * Object setters and getters
     */
    use ObjectTrait;
    
    private $container;
    
    public function __construct(Container $container)
    {
        $this->container = $container;
    }
    
    public function getJobs()
    {
        return $this->container->get('entity.job');
    }
    
    public function getJobsTypes()
    {
        return $this->container->get('entity.jobsTypes');
    }

    public function getJobsCategories()
    {
        return $this->container->get('entity.jobsCategories');
    }
}