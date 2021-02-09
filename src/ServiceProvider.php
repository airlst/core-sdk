<?php

namespace AirLST\CoreSdk;


use AirLST\CoreSdk\Api\WorkerCreator;

/**
 * Class ServiceProvider
 *
 * @package AirLST\CoreSdk
 *
 * @author Michael Thaller <m.thaller@airlst.com>
 */
class ServiceProvider extends \Illuminate\Support\ServiceProvider
{

    /**
     *
     */
    public function register()
    {
        parent::register();

        $this->mergeConfigFrom(
            __DIR__ . '/../config/airlst-sdk.php', 'airlst-sdk'
        );

        $this->app->bind('airlst.core-api', function ($app) {
            return new WorkerCreator();
        });
    }

    /**
     *
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/airlst-sdk.php' => config_path('airlst-sdk.php'),
        ], 'config');
    }
}
