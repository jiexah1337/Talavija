<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 19-Feb-18
 * Time: 11:33 AM
 */

namespace Repositories\Location;
use Entities;
use Entities\Location;
use Illuminate\Database\Eloquent\Model;
use Barryvdh\Debugbar\Facade as Debugbar;

class LocationRepository implements LocationInterface
{
    protected $location;

    public function __construct(Model $location){
        $this->location = $location;
    }

    public function getLocationById($id){
        if ($id !== null){
            return Entities\Location::where('id', $id);
        }
        return null;
    }

    public function createDefault()
    {
        Debugbar::info('Location repo | Creating default Location...');

        $location = Location::create([
            'country'   =>  " ",
            'city'      =>  " ",
            'address'   =>  " ",
            'notes'     =>  " "
        ]);
        Debugbar::info('Location repo | Saving location...');
        $location->save();
        Debugbar::info('Location repo | Location saved!...');
        return $location;
    }

}