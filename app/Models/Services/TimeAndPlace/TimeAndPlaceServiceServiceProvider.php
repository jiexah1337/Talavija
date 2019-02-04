<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 19-Feb-18
 * Time: 11:35 AM
 */

namespace Services\TimeAndPlace;

use Entities\TimeAndPlace;
use Illuminate\Support\ServiceProvider;

class TimeAndPlaceServiceServiceProvider extends ServiceProvider
{
    public function register(){
        $this->app->bind('TimeAndPlaceService', function($app)
        {
            return new TimeAndPlaceService(
                $app->make('Repositories\TimeAndPlace\TimeAndPlaceInterface')
            );
        });
    }
}