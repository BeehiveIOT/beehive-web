<?php
namespace Beehive\Service\Bridge;
use Illuminate\Support\ServiceProvider;

class BridgeServiceProvider extends ServiceProvider
{
    public function register()
    {
        $app = $this->app;

        $app->bind('Beehive\Service\Bridge\Bridge', function($app) {
            return new HttpPublishBridge();
        });
    }
}
