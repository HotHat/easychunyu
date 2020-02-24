<?php


namespace EasyChunYu\Kernel;


use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class LogServiceProvider  implements ServiceProviderInterface
{

    public function register(Container $pimple)
    {
        $pimple['logger'] = $pimple['log'] = function ($app) {

            $log = new Logger('chunyuyisheng');
            $log->pushHandler(
                new StreamHandler($app['config']->get('log_path') ?? '/tmp/chunyuyisheng.log',
                Logger::DEBUG
            ));
            return $log;
        };

    }
}
