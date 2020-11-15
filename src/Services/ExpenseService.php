<?php


namespace App\Services;


use App\Entity\Expense;

class ExpenseService
{
    private $manager;
    public function __construct($worker)
    {
        $this->manager = $worker;
    }
    public function add($expense)
    {
        $expense->setCreationDate(new \DateTime());
        $this->manager->getManager()->persist($expense);
        $this->manager->getManager()->flush();
    }

    public function update($expenseToUpdate, $newExpense)
    {
        $expenseToUpdate->setTitle($newExpense->getTitle());
        $expenseToUpdate->setDescription($newExpense->getDescription());
        $expenseToUpdate->setAmount($newExpense->getAmount());
        $this->manager->getManager()->persist($expenseToUpdate);
        $this->manager->getManager()->flush();
    }

    public function delete($id)
    {
        $expenseToRemove = $this->manager->getRepository(Expense::class)->find($id);
        $this->manager->getManager()->remove($expenseToRemove);
        $this->manager->getManager() ->flush();
    }
}