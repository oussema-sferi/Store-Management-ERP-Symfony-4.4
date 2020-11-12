<?php

namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;


class CategoryService
{
    private $manager;
    public function __construct(EntityManagerInterface $e)
    {
       $this->manager=$e;
    }
    public function addCategory(EntityManagerInterface $e, $title)
    {

        $this->manager->persist($title);
        $this->manager->flush();
    }
}