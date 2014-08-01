<?php
namespace SearchTime\ServiceProvider;

use SearchTime\Services\Trend\GoogleTrender;
use SearchTime\Services\Trend\Trend;
use SearchTime\Services\Trend\TrendHandler;
use Silex\Application;
use Silex\ServiceProviderInterface;

class TrendServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['xgoogle.trendHandler'] = function() {
            return new TrendHandler();
        };

        $app['xgoogle.trendHandler'] = $app->extend('xgoogle.trendHandler', function ($trendHandler) {
            $trendHandler->addTrender(new GoogleTrender());
            //$trendHandler->addTrender(new YahooTrender($client));
            return $trendHandler;
        });

        $app['xgoogle.trend'] = $app->share(function () use ($app) {
            return new Trend($app['xgoogle.trendHandler']);
        });
    }

    public function boot(Application $app)
    {
    }
}
