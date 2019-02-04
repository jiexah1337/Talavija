<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 19-Feb-18
 * Time: 2:16 PM
 */

namespace Repositories\Residence;

use Entities\Residence;
use Repositories\Residence\ResidenceRepository;
use Illuminate\Support\ServiceProvider;

class ResidenceRepositoryServiceProvider extends ServiceProvider
{
    public function register(){
        $this->app->bind('Repositories\Residence\ResidenceInterface', function($app){
            return new ResidenceRepository(new Residence);
        });
    }
}