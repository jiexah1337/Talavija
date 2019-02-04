<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 19-Feb-18
 * Time: 12:34 PM
 */

namespace Repositories\Status;

use Entities;
use Illuminate\Database\Eloquent\Model;

class StatusRepository implements StatusInterface
{
    protected $status;

    public function __construct(Model $status) {
        $this->status = $status;
    }

    public function getStatusById($id)
    {
        if ($id !== null){
            return Entities\Status::where('id',$id);
        }
        return null;
    }

}