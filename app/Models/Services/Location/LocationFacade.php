<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 19-Feb-18
 * Time: 11:34 AM
 */

namespace Services\Location;

use \Illuminate\Support\Facades\Facade;

class LocationFacade extends Facade
{
    protected static function getFacadeAccessor() { return 'LocationService'; }
}