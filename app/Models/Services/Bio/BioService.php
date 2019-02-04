<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 19-Feb-18
 * Time: 11:03 AM
 */

namespace Services\Bio;
use Repositories\Bio\BioInterface;
use Barryvdh\Debugbar\Facade as Debugbar;

class BioService
{
    protected $bioRepo;

    public function __construct(BioInterface $bioRepo){
        $this->bioRepo = $bioRepo;
    }

    public function getBio($bio) {
        if ($bio === null) {
            return null;
        }

        $bio = $this->bioRepo->getBioByMemberId($bio);
        if ($bio !== null) {
            return $bio;
        }
        return null;
    }

    public function createDefault($member_id){
        if ($member_id !== null){
            Debugbar::info('Bio service | createDefault : Found Member ID : '.$member_id);
            $bio = $this->bioRepo->createDefault($member_id);
            return $bio;
        }
        Debugbar::warning('DEFAULT_BIO: MEMBER ID NOT PASSED!');
        return null;
    }
}