<?php

namespace App\Controller;

use App\Entity\Manager;
use App\Form\RegistrationFormType;
use App\Services\ManagerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ManagerController extends AbstractController
{
    /**
     * @Route("/admin/manager", name="manager")
     */
    public function index(): Response
    {
        return $this->render('/admin/managers/index.html.twig', ['managers' => $this->getDoctrine()->getRepository(Manager::class)->findAll()]);
    }


    /**
     * @Route("/admin/manager/delete/{id}", name="delete_manager")
     */
    public function delete($id): Response
    {
        $doctrine = $this->getDoctrine();
        $service = new ManagerService($doctrine);
        $service->delete($id);
        return $this->redirectToRoute('manager');
    }
}
