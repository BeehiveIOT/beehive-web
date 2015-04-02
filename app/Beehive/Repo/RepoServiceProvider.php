<?php
namespace Beehive\Repo;

use Illuminate\Support\ServiceProvider;
use Beehive\Repo\Device\DeviceRepoImpl;
use Beehive\Repo\Template\TemplateRepoImpl;
use Beehive\Repo\Command\CommandRepoImpl;
use Beehive\Repo\Argument\ArgumentRepoImpl;
use Beehive\Repo\User\UserRepoImpl;
use Beehive\Repo\Auth\AuthRepoImpl;
use Beehive\Repo\DataStream\DataStreamRepoImpl;
use Device;
use Template;
use Command;
use Argument;
use User;
use RestToken;
use DataStream;

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
                $app->make('Beehive\Repo\Argument\ArgumentRepo'),
                $app->make('Beehive\Service\Bridge\Bridge')
            );
        });

        $app->bind('Beehive\Repo\Argument\ArgumentRepo', function($app) {
            return new ArgumentRepoImpl(new Argument());
        });

        $app->bind('Beehive\Repo\User\UserRepo', function($app) {
            return new UserRepoImpl(new User());
        });

        $app->bind('Beehive\Repo\Auth\AuthRepo', function($app) {
            $expiration_time = \Config::get('session.rest_token_expiration');
            $userRepo = $app->make('Beehive\Repo\User\UserRepo');

            return new AuthRepoImpl(new RestToken(), $userRepo, $expiration_time);
        });

        $app->bind('Beehive\Repo\DataStream\DataStreamRepo', function($app) {
            return new DataStreamRepoImpl(new DataStream());
        });

    }

    public function boot() {

    }
}
