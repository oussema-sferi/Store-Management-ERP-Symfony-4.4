<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AttendanceController extends AbstractController
{
    /**
     * @Route("/attendance", name="attendance")
     */
    public function index(): Response
    {
        return $this->render('/admin/attendance/index.html.twig', [
            'controller_name' => 'AttendanceController',
        ]);
    }
}