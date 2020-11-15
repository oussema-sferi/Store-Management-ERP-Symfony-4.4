<?php


namespace App\Services;


use App\Entity\Store;

class StoreService
{
    private $manager;
    public function __construct($worker)
    {
        $this->manager = $worker;
    }
    public function add($store)
    {
        $store->setCreationDate(new \DateTime());
        $this->manager->getManager()->persist($store);
        $this->manager->getManager()->flush();
    }

    public function update($storeToUpdate, $newStore)
    {
        $storeToUpdate->setName($newStore->getName());
        $storeToUpdate->setPhone($newStore->getPhone());
        $storeToUpdate->setLogin($newStore->getLogin());
        $storeToUpdate->setPassword($newStore->getPassword());
        $this->manager->getManager()->persist($storeToUpdate);
        $this->manager->getManager()->flush();
    }

    public function delete($id)
    {
        $storeToRemove = $this->manager->getRepository(Store::class)->find($id);
        $this->manager->getManager()->remove($storeToRemove);
        $this->manager->getManager() ->flush();
    }
}