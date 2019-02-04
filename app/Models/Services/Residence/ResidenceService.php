<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 19-Feb-18
 * Time: 11:34 AM
 */

namespace Services\Residence;
use Repositories\Residence\ResidenceInterface;

class ResidenceService
{
    protected $residenceRepo;

    public function __construct(ResidenceInterface $residenceRepo){
        $this->residenceRepo = $residenceRepo;
    }

    public function getResidence($residence){
        if ($residence === null) {
            return null;
        }

        $residence = $this->residenceRepo->getResidenceById($residence);
        if ($residence !== null)
        {
            return $residence;
        }
        return null;
    }

    public function getResidences($member_id){
        if ($member_id === null){
            return null;
        }

        $residences = $this->residenceRepo->getResidences($member_id);
        if ($residences !== null)
        {
            return $residences;
        }
        return null;

    }

    public function getActive($member_id){
        return $this->residenceRepo->getActive($member_id);
    }

    public function getInactive($member_id){
        return $this->residenceRepo->getInactive($member_id);
    }
}