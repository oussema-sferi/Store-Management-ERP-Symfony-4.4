<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StoreAttendanceController extends AbstractController
{
    /**
     * @Route("/manager/store/attendance", name="store_attendance")
     */
    public function index(): Response
    {
        return $this->render('store/attendance/index.html.twig', [
            'controller_name' => 'StoreAttendanceController',
        ]);
    }
}
