<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 19-Feb-18
 * Time: 12:18 PM
 */

namespace Repositories\Study;


interface StudyInterface
{
    public function getStudyById($id);
    public function getActive($member_id);
    public function getInactive($member_id);
}