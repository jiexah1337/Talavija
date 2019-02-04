<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 19-Feb-18
 * Time: 11:34 AM
 */

namespace Services\Workplace;
use Repositories\Workplace\WorkplaceInterface;
use Barryvdh\Debugbar\Facade as Debugbar;

class WorkplaceService
{
    protected $workplaceRepo;

    public function __construct(WorkplaceInterface $workplaceRepo){
        $this->workplaceRepo = $workplaceRepo;
    }

    public function getWorkplace($workplace){
        if ($workplace === null) {
            return null;
        }

        $workplace = $this->workplaceRepo->getWorkplaceById($workplace);
        if ($workplace !== null)
        {
            return $workplace;
        }
        return null;
    }

    public function getWorkplaces($member_id){
        Debugbar::info('Workplace service | getWorkplaces : Finding Workplaces of member '.$member_id);
        if ($member_id === null){
            return null;
        }

        $workplaces = $this->workplaceRepo->getWorkplaces($member_id);
        if ($workplaces !== null)
        {
            return $workplaces;
        }
        return null;
    }



    public function getActive($member_id){
        Debugbar::info('Workplace Service : Getting active Workplaces from member '.$member_id);
        return $this->workplaceRepo->getActive($member_id);
    }

    public function getInactive($member_id){
        Debugbar::info('Workplace Service : Getting inactive Workplaces from member '.$member_id);
        return $this->workplaceRepo->getInactive($member_id);
    }
}