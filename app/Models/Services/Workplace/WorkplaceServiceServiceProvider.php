<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 19-Feb-18
 * Time: 11:35 AM
 */

namespace Services\Workplace;

use Illuminate\Support\ServiceProvider;

class WorkplaceServiceServiceProvider extends ServiceProvider
{
    public function register(){
        $this->app->bind('WorkplaceService', function($app)
        {
            return new WorkplaceService(
                $app->make('Repositories\Workplace\WorkplaceInterface')
            );
        });
    }
}