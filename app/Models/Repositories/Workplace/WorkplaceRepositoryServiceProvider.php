<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 19-Feb-18
 * Time: 2:18 PM
 */

namespace Repositories\Workplace;

use Entities\Workplace;
use Illuminate\Support\ServiceProvider;

class WorkplaceRepositoryServiceProvider extends ServiceProvider
{
    public function register(){
        $this->app->bind('Repositories\Workplace\WorkplaceInterface', function($app){
            return new WorkplaceRepository(new Workplace);
        });
    }
}