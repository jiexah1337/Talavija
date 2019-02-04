<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 19-Feb-18
 * Time: 12:17 PM
 */

namespace Repositories\Residence;


interface ResidenceInterface
{
    public function getResidenceById($id);
    public function getResidences($member_id);
    public function getActive($member_id);
    public function getInactive($member_id);
}