<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 19-Feb-18
 * Time: 12:34 PM
 */

namespace Repositories\Residence;

use Entities;
use Illuminate\Database\Eloquent\Model;

class ResidenceRepository implements ResidenceInterface
{
    protected $residence;

    public function __construct(Model $residence) {
        $this->residence = $residence;
    }

    public function getResidenceById($id)
    {
        if ($id !== null){
            return Entities\Residence::where('id',$id);
        }
        return null;
    }

    public function getResidences($member_id){
        if ($member_id !== null){
            $user = Entities\User::where('member_id',$member_id)->first();;
            return $user->residences->sortByDesc('start_date')->all();
        }
        return null;
    }

    public function getActive($member_id){
        if ($member_id !== null){
            $user = Entities\User::where('member_id',$member_id)->first();
            return $user->residences->where('end_date','==',null)->sortByDesc('start_date')->all();
        }
        return null;
    }

    public function getInactive($member_id){
        if ($member_id !== null){
            $user = Entities\User::where('member_id',$member_id)->first();
            return $user->residences->where('end_date','!=', null)->sortByDesc('start_date')->all();
        }
        return null;
    }
}