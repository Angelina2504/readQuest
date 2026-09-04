<?php

namespace App\Service;

use Doctrine\ODM\MongoDB\DocumentManager;
use App\Document\ActivityLog;

class ActivityLogService
{
    public function __construct(

    private DocumentManager $dm,
    ) {}

    public function log($userId, $action, $details): void
    {
        try {
            $log = new ActivityLog();
            $log->setUserId($userId);
            $log->setAction($action);
            $log->setDetails($details);
            $log->setCreateAt(new \DateTime());

            $this->dm->persist($log);
            $this->dm->flush();
        } catch (\Throwable) {
            // MongoDB unavailable — log silently, don't break the main action
        }
    }

}