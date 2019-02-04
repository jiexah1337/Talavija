<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 19-Feb-18
 * Time: 11:34 AM
 */

namespace Services\TimeAndPlace;
use Repositories\TimeAndPlace\TimeAndPlaceInterface;
use Barryvdh\Debugbar\Facade as Debugbar;

class TimeAndPlaceService
{
    protected $timeAndPlaceRepo;

    public function __construct(TimeAndPlaceInterface $timeAndPlaceRepo){
        $this->timeAndPlaceRepo = $timeAndPlaceRepo;
    }

    public function getTimeAndPlace($timeAndPlace){
        if ($timeAndPlace === null) {
            return null;
        }

        $timeAndPlace = $this->timeAndPlaceRepo->getTAPById($timeAndPlace);
        if ($timeAndPlace !== null)
        {
            return $timeAndPlace;
        }
        return null;
    }

    public function createDefault(){
        Debugbar::info('TAP service | createDefault : Running repo method...');
        return $this->timeAndPlaceRepo->createDefault();
    }
}