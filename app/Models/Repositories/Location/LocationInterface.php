<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 19-Feb-18
 * Time: 11:33 AM
 */

namespace Repositories\Location;

interface LocationInterface
{
    public function getLocationById($id);
    public function createDefault();
}