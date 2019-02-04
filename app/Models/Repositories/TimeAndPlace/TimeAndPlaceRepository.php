<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 19-Feb-18
 * Time: 12:34 PM
 */

namespace Repositories\TimeAndPlace;

use Entities;
use Entities\TimeAndPlace;
use Illuminate\Database\Eloquent\Model;
use Repositories\TimeAndPlace\TimeAndPlaceInterface;
use Services\Location\LocationFacade as Location;
use Barryvdh\Debugbar\Facade as Debugbar;

class TimeAndPlaceRepository implements TimeAndPlaceInterface
{
    protected $timeAndPlace;

    public function __construct(Model $timeAndPlace) {
        $this->timeAndPlace = $timeAndPlace;
    }

    public function getTAPById($id)
    {
        if ($id !== null){
            return Entities\TimeAndPlace::where('id',$id);
        }
        return null;
    }

    public function createDefault(){
        Debugbar::info('TAP repo | createDefault : Creating default TAP...');
        $location = Location::createDefault();

        $tap = TimeAndPlace::create([
            'date'  =>  null,
            'location_id'   =>  $location->id
        ]);
        Debugbar::info('TAP service | createDefault : Saving TAP...');
        $tap->save();
        Debugbar::info('TAP service | createDefault : TAP Saved!');
        return $tap;
    }

}