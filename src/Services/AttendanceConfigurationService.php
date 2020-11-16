<?php


namespace App\Services;


class AttendanceConfigurationService
{
    private $manager;
    public function __construct($worker)
    {
        $this->manager = $worker;
    }

    public function add($attendanceConfig)
    {
        $this->manager->getManager()->persist($attendanceConfig);
        $this->manager->getManager()->flush();
    }

}