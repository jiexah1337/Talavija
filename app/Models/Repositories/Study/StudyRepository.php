<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 19-Feb-18
 * Time: 12:34 PM
 */

namespace Repositories\Study;

use Entities;
use Illuminate\Database\Eloquent\Model;
use Barryvdh\Debugbar\Facade as Debugbar;

class StudyRepository implements StudyInterface
{
    protected $study;

    public function __construct(Model $study) {
        $this->study = $study;
    }

    public function getStudyById($id)
    {
        if ($id !== null){
            return Entities\Study::where('id',$id);
        }
        return null;
    }

    public function getStudies($member_id){
        Debugbar::info('Workplace Repo : Getting Workplaces from member '.$member_id);
        if ($member_id !== null){
            $user = Entities\User::where('member_id',$member_id)->first();;
            return $user->studies->sortByDesc('start_date')->all();
        }
        return null;
    }

    public function getActive($member_id){
        Debugbar::info('Workplace Repo : Getting active Workplaces from member '.$member_id);
        if ($member_id !== null){
            $user = Entities\User::where('member_id',$member_id)->first();
            return $user->studies->where('end_date','==',null)->sortByDesc('start_date')->all();
        }
        return null;
    }

    public function getInactive($member_id){
        Debugbar::info('Workplace Repo : Getting inactive Workplaces from member '.$member_id);
        if ($member_id !== null){
            $user = Entities\User::where('member_id',$member_id)->first();
            return $user->studies->where('end_date','!=', null)->sortByDesc('start_date')->all();
        }
        return null;
    }

}