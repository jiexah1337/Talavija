<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 19-Feb-18
 * Time: 2:18 PM
 */

namespace Repositories\Status;

use Entities\Status;
use Repositories\Status\StatusRepository;
use Illuminate\Support\ServiceProvider;

class StatusRepositoryServiceProvider extends ServiceProvider
{
    public function register(){
        $this->app->bind('Repositories\Status\StatusInterface', function($app){
            return new StatusRepository(new Status);
        });
    }
}