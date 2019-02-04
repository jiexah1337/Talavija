<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 19-Feb-18
 * Time: 11:34 AM
 */

namespace Services\Study;

use \Illuminate\Support\Facades\Facade;

class StudyFacade extends Facade
{
    protected static function getFacadeAccessor() { return 'StudyService'; }
}