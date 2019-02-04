<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 19-Feb-18
 * Time: 2:27 PM
 */

namespace Repositories\TimeAndPlace;


interface TimeAndPlaceInterface
{
    public function getTAPById($id);
    public function createDefault();
}