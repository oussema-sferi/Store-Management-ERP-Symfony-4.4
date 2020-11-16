<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


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

    /**
     * @Route("/manager/store/fetch", name="fetch_products")
     */
    public function fetchProducts(Request $request): Response
    {
        if($request->isXmlHttpRequest()) {
            $id = $request->get('id');
            $category = $this->getDoctrine()->getRepository(Category::class)->find($id);
            if($category instanceof Category) {
                $products = $category->getProducts();
                $serializer = new Serializer([new ObjectNormalizer()]);
                $result = $serializer->normalize($products,'json',['attributes' => ['id','name','price']]);
                return new JsonResponse($result);
            } else {
                return new JsonResponse(['message'=> 'Category not found!']);
            }
        }
        return new Response('use Ajax');
    }

}
