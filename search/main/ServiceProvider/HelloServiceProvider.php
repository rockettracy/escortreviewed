<?php
namespace SearchTime\ServiceProvider;

use Silex\Application;
use Silex\ServiceProviderInterface;

class HelloServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['xgoogle.hello'] = $app->protect(function ($name) use ($app) {
            return 'Hello ' . $name;
        });
    }

    public function boot(Application $app)
    {
    }
}
