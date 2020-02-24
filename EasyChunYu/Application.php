<?php

namespace EasyChunYu;

use EasyChunYu\Kernel\ServiceContainer;

class Application extends ServiceContainer
{
    protected $providers = [
        Base\ServiceProvider::class,
        Common\ServiceProvider::class,
        CrowdSource\ServiceProvider::class,
        Emergency\ServiceProvider::class,
        ImageText\ServiceProvider::class
    ];

    /**
     * @var array
     */
    protected $defaultConfig = [

    ];

    public function __call($name, $arguments)
    {
        return call_user_func_array([$this['base'], $name], $arguments);
    }
}
