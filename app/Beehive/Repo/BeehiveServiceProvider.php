<?php
namespace Beehive\Repo;

use Illuminate\Support\ServiceProvider;

class BeehiveServiceProvider extends ServiceProvider {
    public function register(){
        $app = $this->app;
    }

    public function boot() {

    }
}
