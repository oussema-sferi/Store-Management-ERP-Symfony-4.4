<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;


class StoreOrdersController extends AbstractController
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }
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
    public function new(Request $request): Response
    {
        $currentUser = $this->getUser();
        $catsManager = $this->getDoctrine()->getRepository(Category::class)->getCategoriesWhereStoresWhereManager($currentUser->getId());
        $getProds = $request->getSession()->get('product');
        return $this->render('store/orders/new.html.twig', [
            'catsManager' => $catsManager,
            'prodsFromSession' => $getProds
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

    /**
     * @Route("/manager/store/savesession", name="save_product_session")
     */
    public function saveProdSession(Request $request): Response
    {
        if($request->isXmlHttpRequest()) {
            $id = $request->get('id');
            $product = $this->getDoctrine()->getRepository(Product::class)->find($id);
            $savedProducts = $this->session->get('products');
            if($savedProducts) {
                $savedProducts[]= $product;
                $this->session->set('products', $savedProducts);
            } else {
                $newArray = [];
                array_push($newArray,$product);
                $this->session->set('products', $newArray);
            }

            $serializer = new Serializer([new ObjectNormalizer()]);
            $result = $serializer->normalize($product,'json',['attributes' => ['id','name','price']]);
            return new JsonResponse($result);
        }
        return new Response('use Ajax');
    }

}
