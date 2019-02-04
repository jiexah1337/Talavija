<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 19-Feb-18
 * Time: 10:41 AM
 */

namespace Repositories\Bio;

use Entities\Bio;
use Repositories\Bio\BioRepository;
use Illuminate\Support\ServiceProvider;

class BioRepositoryServiceProvider extends ServiceProvider
{
    public function register(){
        $this->app->bind('Repositories\Bio\BioInterface', function($app){
            return new BioRepository(new Bio);
        });
    }
}