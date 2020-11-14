<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    /**
     * @Route("/admin/order", name="order")
     */
    public function index(): Response
    {
        return $this->render('/admin/orders/index.html.twig', [
            'controller_name' => 'OrderController',
        ]);
    }
}
