<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AttendanceConfigurationController extends AbstractController
{
    /**
     * @Route("/attendance/configuration", name="attendance_configuration")
     */
    public function index(): Response
    {
        return $this->render('/admin/attendanceConfiguration/index.html.twig', [
            'controller_name' => 'AttendanceConfigurationController',
        ]);
    }
}
