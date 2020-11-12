<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StoreOrdersController extends AbstractController
{
    /**
     * @Route("/store/orders", name="store_orders")
     */
    public function index(): Response
    {
        return $this->render('store/orders/index.html.twig', [
            'controller_name' => 'StoreOrdersController',
        ]);
    }

    /**
     * @Route("/store/new", name="new_orders")
     */
    public function new(): Response
    {
        return $this->render('store/orders/new.html.twig', [
            'controller_name' => 'StoreOrdersController',
        ]);
    }
}
