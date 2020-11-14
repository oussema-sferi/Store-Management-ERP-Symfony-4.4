<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Form\EmployeeFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Services\EmployeeService;

class EmployeeController extends AbstractController
{
    /**
     * @Route("/admin/employee", name="employee")
     */
    public function index(): Response
    {
        return $this->render('/admin/employees/index.html.twig', ['employees' => $this->getDoctrine()->getRepository(Employee::class)->findAll()]);
    }

    /**
     * @Route("/admin/employee/new", name="new_employee")
     */
    public function add(Request $request): Response
    {
        $newEmployee = new Employee();
        $employeeForm = $this->createForm(EmployeeFormType::class, $newEmployee);
        $employeeForm->handleRequest($request);
        $doctrine = $this->getDoctrine();
        if($employeeForm->isSubmitted()) {
            $service = new EmployeeService($doctrine);
            $service->add($newEmployee);
            return $this->redirectToRoute('employee');
        }
        return $this->render('/admin/employees/add.html.twig', [
            'form' => $employeeForm->createView()
        ]);
    }

    /**
     * @Route("/admin/employee/update/{id}", name="update_employee")
     */
    public function update(Request $request, $id): Response
    {
        $newEmployee = new Employee();
        $employeeForm = $this->createForm(EmployeeFormType::class, $newEmployee);
        $employeeForm->handleRequest($request);
        $doctrine = $this->getDoctrine();
        $employeeToUpdate= $doctrine->getRepository(Employee::class)->find($id);
        if($employeeForm->isSubmitted()) {
            $service = new EmployeeService($doctrine);
            $service->update($employeeToUpdate, $newEmployee);
            return $this->redirectToRoute('employee');
        }
        return $this->render('/admin/employees/update.html.twig', [
            'form' => $employeeForm->createView(),
            'employeeToUpd' => $employeeToUpdate
        ]);
    }

    /**
     * @Route("/admin/employee/delete/{id}", name="delete_employee")
     */
    public function delete($id): Response
    {
        $doctrine = $this->getDoctrine();
        $service = new EmployeeService($doctrine);
        $service->delete($id);
        return $this->redirectToRoute('employee');
    }

}
