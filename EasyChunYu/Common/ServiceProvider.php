<?php


namespace EasyChunYu\Common;


use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{

    /**
     * @inheritDoc
     */
    public function register(Container $pimple)
    {
        $pimple['common'] = function ($app) {
            return new Client($app);
        };
    }
}
