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
     * @Route("/admin/category", name="category")
     */
    public function index(): Response
    {
        return $this->render('/admin/category/index.html.twig', ['categories' => $this->getDoctrine()->getRepository(Category::class)->findAll()]);
    }

    /**
     * @Route("/admin/category/new", name="new_category")
     */
    public function add(): Response
    {
        $doctrine = $this->getDoctrine();
        if(isset($_POST['title'])) {
            $service = new CategoryService($doctrine);
            $service->add($_POST['title']);
            return $this->redirectToRoute('category');
        }
        return $this->render('/admin/category/add.html.twig');
    }

    /**
     * @Route("/admin/category/update/{id}", name="update_category")
     */
    public function update($id): Response
    {
        $doctrine = $this->getDoctrine();
        $catToUpdate= $doctrine->getRepository(Category::class)->find($id);
        if(isset($_POST['title'])) {
            $service = new CategoryService($doctrine);
            $service->update($id);
            return $this->redirectToRoute('category');
        }
        return $this->render('/admin/category/update.html.twig', [
            'cattoupdate' => $catToUpdate
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
