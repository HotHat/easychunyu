<?php

namespace EasyChunYu;

class Factory
{

    public static function make(array $config)
    {
        return new Application($config);
    }

    /**
     * Dynamically pass methods to the application.
     *
     * @param string $name
     * @param array  $arguments
     *
     * @return mixed
     */
    // public static function __callStatic($name, $arguments)
    // {
    //     return self::make($name, ...$arguments);
    // }
}
