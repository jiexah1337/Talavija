<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 19-Feb-18
 * Time: 11:33 AM
 */

namespace Repositories\Location;

use Entities\Location;
use Illuminate\Support\ServiceProvider;

class LocationRepositoryServiceProvider extends ServiceProvider
{
    public function register(){
        $this->app->bind('Repositories\Location\LocationInterface', function($app){
            return new LocationRepository(new Location);
        });
    }
}