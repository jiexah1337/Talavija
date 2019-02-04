<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 19-Feb-18
 * Time: 11:01 AM
 */

namespace Services\Bio;

use Illuminate\Support\ServiceProvider;

class BioServiceServiceProvider extends ServiceProvider
{
    public function register(){
        $this->app->bind('BioService', function($app)
        {
            return new BioService(
                $app->make('Repositories\Bio\BioInterface')
            );
        });
    }
}