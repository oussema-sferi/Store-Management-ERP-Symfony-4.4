<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\CategoryService;
use Doctrine\ORM\EntityManagerInterface;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category", name="category")
     */
    public function index(): Response
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
        return $this->render('/admin/category/index.html.twig', [
            'controller_name' => 'CategoryController',
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/category/new", name="new_category")
     */
    public function add(): Response
    {
        if(isset($_POST['title'])) {
            $category = new Category();
            $category->setTitle($_POST['title']);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($category);
            $manager->flush();
            return $this->redirectToRoute('category');
        }
        return $this->render('/admin/category/add.html.twig', [
            'controller_name' => 'CategoryController',
        ]);
    }

    /**
     * @Route("/category/update/{id}", name="update_category")
     */
    public function update($id): Response
    {
        $catToUpdate= $this->getDoctrine()->getRepository(Category::class)->find($id);
        if(isset($_POST['title'])) {
            $manager = $this->getDoctrine()->getManager();
            $catToUpdate->setTitle($_POST['title']);
            $manager->flush();
            return $this->redirectToRoute('category');
        }
        return $this->render('/admin/category/update.html.twig', [
            'controller_name' => 'CategoryController',
            'cattoupdate' => $catToUpdate
        ]);
    }

    /**
     * @Route("/category/delete/{id}", name="delete_category")
     */
    public function delete($id): Response
    {
        $manager = $this->getDoctrine()->getManager();
        $catToRemove = $this->getDoctrine()->getRepository(Category::class)->find($id);
        $manager->remove($catToRemove);
        $manager->flush();
        return $this->redirectToRoute('category');
    }
}
