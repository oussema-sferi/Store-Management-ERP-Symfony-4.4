<?php

namespace App\Controller;

use App\Entity\AttendanceConfiguration;
use App\Form\AttendanceConfigurationFormType;
use App\Services\AttendanceConfigurationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AttendanceConfigurationController extends AbstractController
{

    /**
     * @Route("/admin/attendance/configuration", name="attendance_configuration")
     */
    public function index(): Response
    {
        return $this->render('/admin/attendanceConfiguration/index.html.twig', ['attendancesConfig' => $this->getDoctrine()->getRepository(AttendanceConfiguration::class)->findAll()]);
    }

    /**
     * @Route("/admin/attendance/configuration/new", name="new_attendance_configuration")
     */
    public function add(Request $request): Response
    {
        $newAttConfig = new AttendanceConfiguration();
        $attConfigForm = $this->createForm(AttendanceConfigurationFormType::class, $newAttConfig);
        $attConfigForm->handleRequest($request);
        $doctrine = $this->getDoctrine();
        if($attConfigForm->isSubmitted()) {
            $service = new AttendanceConfigurationService($doctrine);
            $service->add($newAttConfig);
            return $this->redirectToRoute('attendance_configuration');
        }
        return $this->render('/admin/attendanceConfiguration/add.html.twig', [
            'form' => $attConfigForm->createView()
        ]);
    }


}
