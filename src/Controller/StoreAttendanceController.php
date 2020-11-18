<?php

namespace App\Controller;

use App\Entity\Attendance;
use App\Entity\Employee;
use App\Form\AttendanceFormType;
use phpDocumentor\Reflection\Types\Null_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class StoreAttendanceController extends AbstractController
{
    /**
     * @Route("/manager/store/attendance", name="store_attendance")
     */
    public function index(Request $request): Response
    {
        $currentUser = $this->getUser();
        $employeesManager = $this->getDoctrine()->getRepository(Employee::class)->getEmployeesWhereStoresWhereManager($currentUser->getId());
        return $this->render('/store/attendance/index.html.twig', [
            'employees' => $employeesManager
        ]);
    }

    /**
     * @Route("/manager/store/attendance/add", name="add_store_attendance")
     */
    public function add(): Response
    {
        if(isset($_POST['employee']) && isset($_POST['check'])) {
            $newAttendance = new Attendance();
            $employee = $this->getDoctrine()->getRepository(Employee::class)->find($_POST['employee']);
            $attendanceToUpd = $this->getDoctrine()->getRepository(Attendance::class)->getAttendanceWhereEmployee($_POST['employee']);
            $newAttendance->setEmployee($employee);
            if($_POST['check'] == 'checkin') {
                if(!$attendanceToUpd) {
                    $newAttendance->setCheckIn(new \DateTime());
                    $newAttendance->setCheckOut(new \DateTime());
                    $newAttendance->setIsValid(true);
                    $manager = $this->getDoctrine()->getManager();
                    $manager->persist($newAttendance);
                    $manager->flush();
                }
            } elseif ($_POST['check'] == 'checkout') {
                if($attendanceToUpd && $attendanceToUpd[0]->getIsValid()) {
                    $attendanceToUpd[0]->setCheckOut(new \DateTime());
                    $attendanceToUpd[0]->setIsValid(false);
                    $manager = $this->getDoctrine()->getManager();
                    $manager->persist($attendanceToUpd[0]);
                    $manager->flush();
                }
            }
            return $this->redirectToRoute('store_orders');
        }
    }
}
