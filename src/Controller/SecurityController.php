<?php

namespace App\Controller;

use App\Entity\Manager;
use App\Form\RegistrationFormType;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/register", name="security_registration")
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $newManager = new Manager();
        $newManager->setRole('ROLE_USER');
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
