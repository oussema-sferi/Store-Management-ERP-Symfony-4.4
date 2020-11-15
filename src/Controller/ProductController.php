<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductFormType;
use App\Services\ProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends AbstractController
{
    /**
     * @Route("/admin/product", name="product")
     */
    public function index(): Response
    {
        return $this->render('/admin/products/index.html.twig', ['products' => $this->getDoctrine()->getRepository(Product::class)->findAll()]);
    }

    /**
     * @Route("/admin/product/new", name="new_product")
     */
    public function add(Request $request): Response
    {
        $newProduct = new Product();
        $productForm = $this->createForm(ProductFormType::class, $newProduct);
        $productForm->handleRequest($request);
        $doctrine = $this->getDoctrine();
        if($productForm->isSubmitted()) {
            $service = new ProductService($doctrine);
            $service->add($newProduct);
            return $this->redirectToRoute('product');
        }
        return $this->render('/admin/products/add.html.twig', [
            'form' => $productForm->createView()
        ]);
    }

    /**
     * @Route("/admin/product/update/{id}", name="update_product")
     */
    public function update(Request $request, $id): Response
    {
        $newProduct = new Product();
        $productForm = $this->createForm(ProductFormType::class, $newProduct);
        $productForm->handleRequest($request);
        $doctrine = $this->getDoctrine();
        $productToUpdate= $doctrine->getRepository(Product::class)->find($id);
        if($productForm->isSubmitted()) {
            $service = new ProductService($doctrine);
            $service->update($productToUpdate, $newProduct);
            return $this->redirectToRoute('product');
        }
        return $this->render('/admin/products/update.html.twig', [
            'form' => $productForm->createView(),
            'productToUpd' => $productToUpdate
        ]);
    }

    /**
     * @Route("/admin/product/delete/{id}", name="delete_product")
     */
    public function delete($id): Response
    {
        $doctrine = $this->getDoctrine();
        $service = new ProductService($doctrine);
        $service->delete($id);
        return $this->redirectToRoute('product');
    }

}
