<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StoreController extends AbstractController
{
    /**
     * @Route("/admin/store", name="store")
     */
    public function index(): Response
    {
        return $this->render('/admin/store/index.html.twig', [
            'controller_name' => 'StoreController',
        ]);
    }

    /**
     * @Route("/admin/store/new", name="new_store")
     */
    public function add(): Response
    {
        return $this->render('/admin/store/add.html.twig', [
            'controller_name' => 'CategoryController',
        ]);
    }
}
