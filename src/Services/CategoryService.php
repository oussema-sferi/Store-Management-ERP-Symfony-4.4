<?php

namespace App\Services;

use App\Entity\Category;



class CategoryService
{
    private $manager;
    public function __construct($worker)
    {
        $this->manager = $worker;
    }
    public function add($category)
    {
        $this->manager->getManager()->persist($category);
        $this->manager->getManager()->flush();
    }

    public function update($categoryToUpdate, $newCategory)
    {
        $categoryToUpdate->setTitle($newCategory->getTitle());
        $this->manager->getManager()->persist($categoryToUpdate);
        $this->manager->getManager()->flush();
    }

    public function delete($id)
    {
        $catToRemove = $this->manager->getRepository(Category::class)->find($id);
        $this->manager->getManager()->remove($catToRemove);
        $this->manager->getManager() ->flush();
    }
}