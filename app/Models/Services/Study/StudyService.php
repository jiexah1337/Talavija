<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 19-Feb-18
 * Time: 11:34 AM
 */

namespace Services\Study;
use Repositories\Study\StudyInterface;

class StudyService
{
    protected $studyRepo;

    public function __construct(StudyInterface $studyRepo){
        $this->studyRepo = $studyRepo;
    }

    public function getStudy($study){
        if ($study === null) {
            return null;
        }

        $study = $this->studyRepo->getStudyById($study);
        if ($study !== null)
        {
            return $study;
        }
        return null;
    }

    public function getStudies($member_id){
        if ($member_id === null){
            return null;
        }

        $studies = $this->studyRepo->getStudies($member_id);
        if ($studies !== null)
        {
            return $studies;
        }
        return null;

    }

    public function getActive($member_id){
        return $this->studyRepo->getActive($member_id);
    }

    public function getInactive($member_id){
        return $this->studyRepo->getInactive($member_id);
    }
}