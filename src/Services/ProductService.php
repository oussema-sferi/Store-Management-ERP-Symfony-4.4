<?php


namespace App\Services;


use App\Entity\Product;

class ProductService
{
    private $manager;
    public function __construct($worker)
    {
        $this->manager = $worker;
    }
    public function add($product)
    {
        $this->manager->getManager()->persist($product);
        $this->manager->getManager()->flush();
    }

    public function update($productToUpdate, $newProduct)
    {
        $productToUpdate->setName($newProduct->getName());
        $productToUpdate->setPrice($newProduct->getPrice());
        $this->manager->getManager()->persist($productToUpdate);
        $this->manager->getManager()->flush();
    }

    public function delete($id)
    {
        $productToRemove = $this->manager->getRepository(Product::class)->find($id);
        $this->manager->getManager()->remove($productToRemove);
        $this->manager->getManager() ->flush();
    }
}