<?php
namespace Beehive\Repo;

use Illuminate\Support\ServiceProvider;
use Beehive\Repo\Device\DeviceRepoImpl;
use Beehive\Repo\Template\TemplateRepoImpl;
use Device;
use Template;

class RepoServiceProvider extends ServiceProvider {
    public function register(){
        $app = $this->app;

        $app->bind('Beehive\Repo\Device\DeviceRepo', function($app) {
            return new DeviceRepoImpl(
                new Device(),
                $app->make('Beehive\Repo\Template\TemplateRepo'));
        });

        $app->bind('Beehive\Repo\Template\TemplateRepo', function($app) {
            return new TemplateRepoImpl(new Template());
        });
    }

    public function boot() {

    }
}
