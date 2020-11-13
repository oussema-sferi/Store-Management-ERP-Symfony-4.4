<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Form\EmployeeFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmployeeController extends AbstractController
{
    /**
     * @Route("/employee", name="employee")
     */
    public function index(): Response
    {
        return $this->render('/admin/employees/index.html.twig', [
            'controller_name' => 'EmployeeController',
        ]);
    }

    /**
     * @Route("/employee/new", name="new_employee")
     */
    public function add(): Response
    {
        $newEmployee = new Employee();
        $employeeForm = $this->createForm(EmployeeFormType::class, $newEmployee);
        return $this->render('/admin/employees/add.html.twig', [
            'form' => $employeeForm->createView()
        ]);
    }
}
