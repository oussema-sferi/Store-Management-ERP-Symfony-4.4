<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\CategoryService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends AbstractController
{
    /**
     * @Route("/admin/category", name="category")
     */
    public function index(): Response
    {
        return $this->render('/admin/category/index.html.twig', ['categories' => $this->getDoctrine()->getRepository(Category::class)->findAll()]);
    }

    /**
     * @Route("/admin/category/new", name="new_category")
     */
    public function add(Request $request): Response
    {
        $newCategory = new Category();
        $categoryForm = $this->createForm(CategoryFormType::class, $newCategory);
        $categoryForm->handleRequest($request);
        $doctrine = $this->getDoctrine();
        if($categoryForm->isSubmitted()) {
            $service = new CategoryService($doctrine);
            $service->add($newCategory);
            return $this->redirectToRoute('category');
        }
        return $this->render('/admin/category/add.html.twig', [
            'form' => $categoryForm->createView()
        ]);
    }

    /**
     * @Route("/admin/category/update/{id}", name="update_category")
     */
    public function update(Request $request, $id): Response
    {
        $newCategory = new Category();
        $categoryForm = $this->createForm(CategoryFormType::class, $newCategory);
        $categoryForm->handleRequest($request);
        $doctrine = $this->getDoctrine();
        $categoryToUpdate= $doctrine->getRepository(Category::class)->find($id);
        if($categoryForm->isSubmitted()) {
            $service = new CategoryService($doctrine);
            $service->update($categoryToUpdate, $newCategory);
            return $this->redirectToRoute('category');
        }
        return $this->render('/admin/category/update.html.twig', [
            'form' => $categoryForm->createView(),
            'categoryToUpd' => $categoryToUpdate
        ]);
    }

    /**
     * @Route("/admin/category/delete/{id}", name="delete_category")
     */
    public function delete($id): Response
    {
        $doctrine = $this->getDoctrine();
        $service = new CategoryService($doctrine);
        $service->delete($id);
        return $this->redirectToRoute('category');
    }
}
