<?php

namespace App\Controller;

use App\Entity\Store;
use App\Form\StoreFormType;
use App\Services\StoreService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class StoreController extends AbstractController
{
    /**
     * @Route("/admin/store", name="store")
     */
    public function index(): Response
    {
        return $this->render('/admin/stores/index.html.twig', ['stores' => $this->getDoctrine()->getRepository(Store::class)->findAll()]);
    }

    /**
     * @Route("/admin/store/new", name="new_store")
     */
    public function add(Request $request): Response
    {
        $newStore = new Store();
        $storeForm = $this->createForm(StoreFormType::class, $newStore);
        $storeForm->handleRequest($request);
        $doctrine = $this->getDoctrine();
        if($storeForm->isSubmitted()) {
            $service = new StoreService($doctrine);
            $service->add($newStore);
            return $this->redirectToRoute('store');
        }
        return $this->render('/admin/stores/add.html.twig', [
            'form' => $storeForm->createView()
        ]);
    }

    /**
     * @Route("/admin/store/update/{id}", name="update_store")
     */
    public function update(Request $request, $id): Response
    {
        $newStore = new Store();
        $storeForm = $this->createForm(StoreFormType::class, $newStore);
        $storeForm->handleRequest($request);
        $doctrine = $this->getDoctrine();
        $storeToUpdate= $doctrine->getRepository(Store::class)->find($id);
        if($storeForm->isSubmitted()) {
            $service = new StoreService($doctrine);
            $service->update($storeToUpdate, $newStore);
            return $this->redirectToRoute('store');
        }
        return $this->render('/admin/stores/update.html.twig', [
            'form' => $storeForm->createView(),
            'storeToUpd' => $storeToUpdate
        ]);
    }

    /**
     * @Route("/admin/store/delete/{id}", name="delete_store")
     */
    public function delete($id): Response
    {
        $doctrine = $this->getDoctrine();
        $service = new StoreService($doctrine);
        $service->delete($id);
        return $this->redirectToRoute('store');
    }

}
