<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 19-Feb-18
 * Time: 12:34 PM
 */

namespace Repositories\Workplace;

use Entities;
use Illuminate\Database\Eloquent\Model;
use Barryvdh\Debugbar\Facade as Debugbar;

class WorkplaceRepository implements WorkplaceInterface
{
    protected $workplace;

    public function __construct(Model $workplace) {
        $this->workplace = $workplace;
    }

    public function getWorkplaceById($id)
    {
        if ($id != null){
            return Entities\Workplace::where('id',$id);
        }
        return null;
    }

    public function getWorkplaces($member_id){
        Debugbar::info('Workplace Repo : Getting Workplaces from member '.$member_id);
        if ($member_id !== null){
            $user = Entities\User::where('member_id',$member_id)->first();
            return $user->workplaces->sortByDesc('start_date')->all();
        }
        return null;
    }



    public function getActive($member_id){
        Debugbar::info('Workplace Repo : Getting active Workplaces from member '.$member_id);
        if ($member_id !== null){
            $user = Entities\User::where('member_id',$member_id)->first();
            return $user->workplaces->where('end_date','==',null)->sortByDesc('start_date')->all();
        }
        return null;
    }

    public function getInactive($member_id){
        Debugbar::info('Workplace Repo : Getting inactive Workplaces from member '.$member_id);
        if ($member_id !== null){
            $user = Entities\User::where('member_id',$member_id)->first();
            return $user->workplaces->where('end_date','!=', null)->sortByDesc('start_date')->all();
        }
        return null;
    }

}