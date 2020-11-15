<?php


namespace App\Services;


use App\Entity\Manager;

class ManagerService
{
    private $manager;
    public function __construct($worker)
    {
        $this->manager = $worker;
    }

    public function delete($id)
    {
        $managerToRemove = $this->manager->getRepository(Manager::class)->find($id);
        $this->manager->getManager()->remove($managerToRemove);
        $this->manager->getManager() ->flush();
    }
}