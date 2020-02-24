<?php


namespace EasyChunYu\Kernel;


use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class HttpClientServiceProvider implements ServiceProviderInterface
{

    public function register(Container $pimple)
    {
        $pimple['http_client'] = function ($app) {
            $stack = HandlerStack::create();
            $stack->push(
                Middleware::log(
                    $app['logger'],
                    new MessageFormatter(MessageFormatter::DEBUG)
                )
            );
            $config = $app['config']['debug'] ? $app['config']['http_dev'] : $app['config']['http_prod'];
            $config['handler'] = $stack;
            return new Client($config);
        };
    }
}
