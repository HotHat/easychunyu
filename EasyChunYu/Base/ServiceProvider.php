<?php


namespace EasyChunYu\Base;


use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    /**
     * @inheritDoc
     */
    public function register(Container $pimple)
    {
        $pimple['base'] = function ($app) {
            return new Client($app);
        };
    }
}
