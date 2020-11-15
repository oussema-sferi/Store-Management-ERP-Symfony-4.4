<?php

namespace App\Controller;

use App\Entity\Expense;
use App\Form\ExpenseFormType;
use App\Services\ExpenseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ExpenseController extends AbstractController
{
    /**
     * @Route("/admin/expense", name="expense")
     */
    public function index(): Response
    {
        return $this->render('/admin/expenses/index.html.twig', ['expenses' => $this->getDoctrine()->getRepository(Expense::class)->findAll()]);
    }

    /**
     * @Route("/admin/expense/new", name="new_expense")
     */
    public function add(Request $request): Response
    {
        $newExpense = new Expense();
        $expenseForm = $this->createForm(ExpenseFormType::class, $newExpense);
        $expenseForm->handleRequest($request);
        $doctrine = $this->getDoctrine();
        if($expenseForm->isSubmitted()) {
            $service = new ExpenseService($doctrine);
            $service->add($newExpense);
            return $this->redirectToRoute('expense');
        }
        return $this->render('/admin/expenses/add.html.twig', [
            'form' => $expenseForm->createView()
        ]);
    }

    /**
     * @Route("/admin/expense/update/{id}", name="update_expense")
     */
    public function update(Request $request, $id): Response
    {
        $newExpense = new Expense();
        $expenseForm = $this->createForm(ExpenseFormType::class, $newExpense);
        $expenseForm->handleRequest($request);
        $doctrine = $this->getDoctrine();
        $expenseToUpdate= $doctrine->getRepository(Expense::class)->find($id);
        if($expenseForm->isSubmitted()) {
            $service = new ExpenseService($doctrine);
            $service->update($expenseToUpdate, $newExpense);
            return $this->redirectToRoute('expense');
        }
        return $this->render('/admin/expenses/update.html.twig', [
            'form' => $expenseForm->createView(),
            'expenseToUpd' => $expenseToUpdate
        ]);
    }

    /**
     * @Route("/admin/expense/delete/{id}", name="delete_expense")
     */
    public function delete($id): Response
    {
        $doctrine = $this->getDoctrine();
        $service = new ExpenseService($doctrine);
        $service->delete($id);
        return $this->redirectToRoute('expense');
    }
}
