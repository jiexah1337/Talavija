<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 19-Feb-18
 * Time: 2:28 PM
 */

namespace Repositories\Workplace;


interface WorkplaceInterface
{
    public function getWorkplaceById($id);
    public function getWorkplaces($member_id);
    public function getActive($member_id);
    public function getInactive($member_id);
}