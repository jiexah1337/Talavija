<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 19-Feb-18
 * Time: 2:18 PM
 */

namespace Repositories\TimeAndPlace;

use Entities\TimeAndPlace;
use Illuminate\Support\ServiceProvider;

class TimeAndPlaceRepositoryServiceProvider extends ServiceProvider
{
    public function register(){
        $this->app->bind('Repositories\TimeAndPlace\TimeAndPlaceInterface', function($app){
            return new TimeAndPlaceRepository(new TimeAndPlace());
        });
    }
}