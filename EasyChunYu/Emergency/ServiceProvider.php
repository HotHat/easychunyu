<?php


namespace EasyChunYu\Emergency;


use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{

    /**
     * @inheritDoc
     */
    public function register(Container $pimple)
    {
        $pimple['emergency'] = function ($app) {
            return new Client($app);
        };
    }
}
