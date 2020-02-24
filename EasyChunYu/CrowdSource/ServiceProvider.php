<?php


namespace EasyChunYu\CrowdSource;


use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{

    /**
     * @inheritDoc
     */
    public function register(Container $pimple)
    {
        $pimple['crowd_source'] = function ($app) {
            return new Client($app);
        };
    }
}
