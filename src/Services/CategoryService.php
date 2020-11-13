<?php

namespace App\Services;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;
use Symfony\Component\HttpFoundation\Response;


class CategoryService
{
    private $manager;
    public function __construct($worker)
    {
        $this->manager = $worker;
    }
    public function add($title)
    {
        $category = new Category();
        $category->setTitle($title);
        $this->manager->getManager()->persist($category);
        $this->manager->getManager()->flush();
    }

    public function update($id)
    {
        $catToUpdate = $this->manager->getRepository(Category::class)->find($id);
        $catToUpdate->setTitle($_POST['title']);
        $this->manager->getManager()->persist($catToUpdate);
        $this->manager->getManager()->flush();
    }

    public function delete($id)
    {
        $catToRemove = $this->manager->getRepository(Category::class)->find($id);
        $this->manager->getManager()->remove($catToRemove);
        $this->manager->getManager() ->flush();
    }
}