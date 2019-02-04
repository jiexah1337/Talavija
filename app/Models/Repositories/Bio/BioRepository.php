<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 19-Feb-18
 * Time: 10:29 AM
 */

namespace Repositories\Bio;

use Entities;
use Entities\Bio;
use Illuminate\Database\Eloquent\Model;
use DB;
use Services\TimeAndPlace\TimeAndPlaceFacade as TimeAndPlace;
use Barryvdh\Debugbar\Facade as Debugbar;

class BioRepository implements BioInterface
{
    protected $bio;

    public function __construct(Model $bio) {
        $this->bio = $bio;


    }

    public function getBioByMemberId($member_id){
        if ($member_id !== null){
            return Entities\Bio::where('member_id',$member_id)->first();
        }
        return null;
    }

    public function createDefault($member_id){
        try {
            DB::transaction(function () use ($member_id) {
                Debugbar::info('Bio repo | createDefault : STARTED TRANSACTION');
                Debugbar::info('Bio repo | createDefault : GENERATING DEFAULT TIME AND PLACES');
                $birthdata = TimeAndPlace::createDefault();
                $deathdata = TimeAndPlace::createDefault();

                Debugbar::info('Bio repo | createDefault : GENERATING BIO');
                $bio = Bio::create([
                    'member_id'     =>  $member_id,
                    'olderman_id'   =>  -1,
                    'col_father_id' =>  -1,
                    'com_mother_id' =>  -1,
                    'birthdata_id'  =>  $birthdata->id,
                    'deathdata_id'  =>  $deathdata->id
                ]);
                Debugbar::info('Bio repo | createDefault : SAVING BIO');
                $bio->save();
                Debugbar::info('Bio repo | createDefault : BIO SAVED!');
            });
        } catch (\Exception $e) {
            return $e->getMessage();
        } catch (\Throwable $e) {
            return $e->getMessage();
        }

        return $this->getBioByMemberId($member_id);
    }


    public function convertFormat($bio){
        if ($bio !== null){
            $object = new \stdClass();
            $object->id              = $bio->id;
            $object->member_id       = $bio->member_id;
            $object->olderman_id     = $bio->olderman_id;
            $object->col_father_id   = $bio->col_father_id;
            $object->col_mother_id   = $bio->col_mother_id;
            $object->birthdata_id    = $bio->birthdata_id;
            $object->deathdata_id    = $bio->deathdata_id;
            $object->father          = $bio->father;
            $object->mother          = $bio->mother;
            $object->children        = $bio->children;
            $object->notes           = $bio->notes;

            return $object;
        }
        return null;
    }
}