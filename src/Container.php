<?php

namespace Cleantekker;

class Container
{
    /**
     * @var
     */
    private static $container;

    /**
     * @param \League\Container\Container $container
     */
    public static function set(\League\Container\Container $container)
    {
        self::$container = $container;
    }

    /**
     * @return \League\Container\Container $container
     */
    public static function get()
    {
        return self::$container;
    }
}