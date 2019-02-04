<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 19-Feb-18
 * Time: 11:35 AM
 */

namespace Services\Study;

use Illuminate\Support\ServiceProvider;

class StudyServiceServiceProvider extends ServiceProvider
{
    public function register(){
        $this->app->bind('StudyService', function($app)
        {
            return new StudyService(
                $app->make('Repositories\Study\StudyInterface')
            );
        });
    }
}