<?php

namespace App\Controller;

use App\Entity\Manager;
use App\Form\RegistrationFormType;
use App\Services\ManagerService;
use Doctrine\Persistence\ObjectManager;
use phpDocumentor\Reflection\Types\Array_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/admin/adduser", name="security_registration")
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $newManager = new Manager();
        $newManager->setCreationDate(new \DateTime());
        $form = $this->createForm(RegistrationFormType::class, $newManager);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($newManager, $newManager->getPassword());
            $newManager->setPassword($hash);
            $man = $this->getDoctrine()->getManager();
            $man->persist($newManager);
            $man->flush();
            return $this->redirectToRoute('security_login');
        }
        return $this->render('/admin/security/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/manager/update/{id}", name="update_manager")
     */
    public function update(Request $request, UserPasswordEncoderInterface $encoder,$id): Response
    {
        $newManager = new Manager();
        $newManager->setCreationDate(new \DateTime());
        $form = $this->createForm(RegistrationFormType::class, $newManager);
        $form->handleRequest($request);
        $managerToUpdate= $this->getDoctrine()->getRepository(Manager::class)->find($id);
        if($form->isSubmitted()) {
            $hash = $encoder->encodePassword($newManager, $newManager->getPassword());
            $managerToUpdate->setFullName($newManager->getFullName());
            $managerToUpdate->setUsername($newManager->getUsername());
            $managerToUpdate->setRoles(array());
            $managerToUpdate->setRoles($newManager->getRoles());
            $managerToUpdate->setPassword($hash);
            $man = $this->getDoctrine()->getManager();
            $man->persist($managerToUpdate);
            $man->flush();
            return $this->redirectToRoute('manager');
        }
        return $this->render('/admin/managers/update.html.twig', [
            'form' => $form->createView(),
            'managerToUpd' => $managerToUpdate
        ]);
    }

    /**
     * @Route("/login", name="security_login")
     */
    public function login(): Response
    {
        return $this->render('/admin/security/login.html.twig');
    }

    /**
     * @Route("/logout", name="security_logout")
     */
    public function logout(): Response
    {

    }
}
