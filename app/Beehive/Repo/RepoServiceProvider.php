<?php
namespace Beehive\Repo;

use Illuminate\Support\ServiceProvider;
use Beehive\Repo\Device\DeviceRepoImpl;
use Beehive\Repo\Template\TemplateRepoImpl;
use Beehive\Repo\Command\CommandRepoImpl;
use Beehive\Repo\Argument\ArgumentRepoImpl;
use Device;
use Template;
use Command;
use Argument;

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
            return new CommandRepoImpl(
                new Command(),
                $app->make('Beehive\Repo\Template\TemplateRepo'),
                $app->make('Beehive\Repo\Argument\ArgumentRepo')
            );
        });

        $app->bind('Beehive\Repo\Argument\ArgumentRepo', function($app) {
            return new ArgumentRepoImpl(new Argument());
        });
    }

    public function boot() {

    }
}
