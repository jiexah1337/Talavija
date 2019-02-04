<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 19-Feb-18
 * Time: 11:35 AM
 */

namespace Services\Location;

use Illuminate\Support\ServiceProvider;

class LocationServiceServiceProvider extends ServiceProvider
{
    public function register(){
        $this->app->bind('LocationService', function($app)
        {
            return new LocationService(
                $app->make('Repositories\Location\LocationInterface')
            );
        });
    }
}