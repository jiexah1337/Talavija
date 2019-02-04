<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 19-Feb-18
 * Time: 10:26 AM
 */

namespace Repositories\Bio;


interface BioInterface
{
    public function getBioByMemberId($member_id);
    public function createDefault($member_id);
}