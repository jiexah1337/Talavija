<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 19-Feb-18
 * Time: 11:34 AM
 */

namespace Services\Location;
use Repositories\Location\LocationInterface;
use Barryvdh\Debugbar\Facade as Debugbar;

class LocationService
{
    protected $locationRepo;

    public function __construct(LocationInterface $locationRepo){
        $this->locationRepo = $locationRepo;
    }

    public function getLocation($location){
        if ($location === null) {
            return null;
        }

        $location = $this->locationRepo->getLocationById($location);
        if ($location !== null)
        {
            return $location;
        }
        return null;
    }

    public function createDefault(){
        Debugbar::info('Location service | createDefault : Running repo method createDefault...');
        return $this->locationRepo->createDefault();
    }
}