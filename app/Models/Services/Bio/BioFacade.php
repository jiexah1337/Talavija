<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 19-Feb-18
 * Time: 11:09 AM
 */

namespace Services\Bio;

use \Illuminate\Support\Facades\Facade;

class BioFacade extends Facade
{
    protected static function getFacadeAccessor() { return 'BioService'; }
}