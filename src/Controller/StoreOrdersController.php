<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StoreOrdersController extends AbstractController
{
    /**
     * @Route("/manager/store/orders", name="store_orders")
     */
    public function index(): Response
    {
        return $this->render('store/orders/index.html.twig', [
            'controller_name' => 'StoreOrdersController',
        ]);
    }

    /**
     * @Route("/manager/store/new", name="new_orders")
     */
    public function new(): Response
    {
        $currentUser = $this->getUser();
        $catsManager = $this->getDoctrine()->getRepository(Category::class)->getCategoriesWhereStoresWhereManager($currentUser->getId());
        return $this->render('store/orders/new.html.twig', [
            'catsManager' => $catsManager,
        ]);
    }


}
