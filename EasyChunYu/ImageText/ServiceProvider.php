<?php


namespace EasyChunYu\ImageText;


use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{

    /**
     * @inheritDoc
     */
    public function register(Container $pimple)
    {
        $pimple['image_text'] = function ($app) {
            return new Client($app);
        };
    }
}
