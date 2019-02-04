<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 19-Feb-18
 * Time: 11:35 AM
 */

namespace Services\Residence;

use Illuminate\Support\ServiceProvider;

class ResidenceServiceServiceProvider extends ServiceProvider
{
    public function register(){
        $this->app->bind('ResidenceService', function($app)
        {
            return new ResidenceService(
                $app->make('Repositories\Residence\ResidenceInterface')
            );
        });
    }
}