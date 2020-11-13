<?php


namespace App\Services;

use App\Entity\Employee;

class EmployeeService
{
    private $manager;
    public function __construct($worker)
    {
        $this->manager = $worker;
    }
    public function add($employee)
    {
        $this->manager->getManager()->persist($employee);
        $this->manager->getManager()->flush();
    }

    public function update($employeetoUpd, $newEmployee)
    {
        $employeetoUpd->setFullName($newEmployee->getFullName());
        $employeetoUpd->setCin($newEmployee->getCin());
        $employeetoUpd->setSalary($newEmployee->getSalary());
        $employeetoUpd->setZone($newEmployee->getZone());
        $employeetoUpd->setAddress($newEmployee->getAddress());
        $employeetoUpd->setIsActive($newEmployee->getIsActive());
        $this->manager->getManager()->persist($employeetoUpd);
        $this->manager->getManager()->flush();
    }

    public function delete($id)
    {
        $employeeToRemove = $this->manager->getRepository(Employee::class)->find($id);
        $this->manager->getManager()->remove($employeeToRemove);
        $this->manager->getManager() ->flush();
    }
}