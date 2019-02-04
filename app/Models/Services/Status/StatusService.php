<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 19-Feb-18
 * Time: 11:34 AM
 */

namespace Services\Status;
use Repositories\Status\StatusInterface;

class StatusService
{
    protected $statusRepo;

    public function __construct(StatusInterface $statusRepo){
        $this->statusRepo = $statusRepo;
    }

    public function getStatus($status){
        if ($status === null) {
            return null;
        }

        $status = $this->statusRepo->getStatusById($status);
        if ($status !== null)
        {
            return $status;
        }
        return null;
    }
}