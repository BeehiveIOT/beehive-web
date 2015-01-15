<?php
namespace Beehive\Service\Validation;

use Illuminate\Support\ServiceProvider;

class ValidationServiceProvider extends ServiceProvider {
    public function register() {
        $app = $this->app;

        $app->bind('Beehive\Service\Validation\DeviceValidator', function($app) {
            return new DeviceValidator($app['validator']);
        });

        $app->bind('Beehive\Service\Validation\TemplateValidator', function($app) {
            return new TemplateValidator($app['validator']);
        });
    }

    public function boot() {

    }
}
