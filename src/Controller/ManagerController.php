<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ManagerController extends AbstractController
{
    /**
     * @Route("/admin/manager", name="manager")
     */
    public function index(): Response
    {
        return $this->render('/admin/managers/index.html.twig', [
            'controller_name' => 'ManagerController',
        ]);
    }

    /**
     * @Route("/admin/manager/new", name="new_manager")
     */
    public function add(): Response
    {
        return $this->render('/admin/managers/add.html.twig', [
            'controller_name' => 'CategoryController',
        ]);
    }
}
