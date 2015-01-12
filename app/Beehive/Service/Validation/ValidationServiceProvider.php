<?php
namespace Beehive\Service\Validation;

use Illuminate\Support\ServiceProvider;

class ValidationServiceProvider extends ServiceProvider {
    public function register() {
        $app = $this->app;

        $app->bind('Beehive\Service\Validation\DeviceValidator', function($app) {
            return new DeviceValidator($app['validator']);
        });
    }

    public function boot() {

    }
}
