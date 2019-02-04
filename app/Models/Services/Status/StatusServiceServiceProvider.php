<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 19-Feb-18
 * Time: 11:35 AM
 */

namespace Services\Status;

use Illuminate\Support\ServiceProvider;

class StatusServiceServiceProvider extends ServiceProvider
{
    public function register(){
        $this->app->bind('StatusService', function($app)
        {
            return new StatusService(
                $app->make('Repositories\Status\StatusInterface')
            );
        });
    }
}