<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 19-Feb-18
 * Time: 12:18 PM
 */

namespace Repositories\Status;


interface StatusInterface
{
    public function getStatusById($id);
}