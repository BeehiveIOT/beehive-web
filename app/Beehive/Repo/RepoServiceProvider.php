<?php
namespace Beehive\Repo;

use Illuminate\Support\ServiceProvider;
use Beehive\Repo\Device\DeviceRepoImpl;
use Beehive\Repo\Template\TemplateRepoImpl;
use Beehive\Repo\Command\CommandRepoImpl;
use Device;
use Template;
use Command;

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

        $app->bind('Beehive\Repo\Command\CommandRepo', function($app) {
            return new CommandRepoImpl(new Command());
        });
    }

    public function boot() {

    }
}
