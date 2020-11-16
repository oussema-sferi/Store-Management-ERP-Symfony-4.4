<?php

namespace App\Controller;

use App\Entity\Attendance;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AttendanceController extends AbstractController
{
    /**
     * @Route("/admin/attendance", name="attendance")
     */
    public function index(): Response
    {
        return $this->render('/admin/attendance/index.html.twig', [
            'attendances' => $this->getDoctrine()->getRepository(Attendance::class)->findAll(),
        ]);
    }


}
