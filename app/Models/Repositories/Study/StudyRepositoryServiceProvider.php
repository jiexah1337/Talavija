<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 19-Feb-18
 * Time: 2:18 PM
 */

namespace Repositories\Study;

use Entities\Study;
use Repositories\Study\TimeAndPlaceRepository;
use Illuminate\Support\ServiceProvider;

class StudyRepositoryServiceProvider extends ServiceProvider
{
    public function register(){
        $this->app->bind('Repositories\Study\StudyInterface', function($app){
            return new StudyRepository(new Study);
        });
    }
}