<?php

namespace App\Controller;

use App\Entity\Course;
use App\Entity\Lesson;
use App\Entity\Purchase;
use App\Entity\Certificate;
use App\Repository\UserRepository;
use App\Repository\CourseRepository;
use App\Repository\LessonRepository;
use App\Repository\PurchaseRepository;
use App\Repository\CertificateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Dompdf\Dompdf;
use Dompdf\Options;

class PageController extends AbstractController
{
    #[Route('/courses', name: 'app_courses')]
    public function courses(CourseRepository $courseRepository): Response
    {
        $courses = $courseRepository->findAll();

        return $this->render('pages/courses.html.twig', [
            'courses' => $courses
        ]);
    }

    #[Route('/my-courses', name: 'app_my_courses')]
    public function myCourses(PurchaseRepository $purchaseRepository): Response
    {
        // Vérifie que l’utilisateur est connecté
        $user = $this->getUser();
        if (!$user) {
            $this->addFlash('error', 'Veuillez vous connecter pour voir vos cours.');
            return $this->redirectToRoute('app_login');
        }

        // Récupère les achats de l’utilisateur connecté
        $purchases = $purchaseRepository->findBy(['utilisateur' => $user]);

        return $this->render('pages/my_courses.html.twig', [
            'purchases' => $purchases
        ]);
    }

    #[Route('/certifications', name: 'app_certifications')]
    public function certifications(CertificateRepository $certificateRepository): Response
    {
        $user = $this->getUser();
        $certificates = $certificateRepository->findBy(['utilisateur' => $user]);

        return $this->render('pages/certifications.html.twig', [
            'certificates' => $certificates
        ]);
    }


    #[Route('/admin', name: 'app_admin')]
    public function admin(
        UserRepository $userRepository,
        CourseRepository $courseRepository,
        PurchaseRepository $purchaseRepository,
        LessonRepository $lessonRepository,
        CertificateRepository $certificateRepository
    ): Response {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $users = $userRepository->findAll();
        $courses = $courseRepository->findAll();
        $purchases = $purchaseRepository->findAll();
        $lessons = $lessonRepository->findAll();
        $certificates = $certificateRepository->findAll();

        return $this->render('pages/admin.html.twig', [
            'users' => $users,
            'courses' => $courses,
            'purchases' => $purchases,
            'lessons' => $lessons,
            'certificates' => $certificates
        ]);
    }

    #[Route('/courses/{id}', name: 'app_course_detail')]
    public function courseDetail(int $id, CourseRepository $courseRepository, LessonRepository $lessonRepository,PurchaseRepository $purchaseRepository): Response
    {
        $course = $courseRepository->find($id);

        if (!$course) {
            throw $this->createNotFoundException('Cours introuvable.');
        }

        $lessons = $lessonRepository->findBy(['course' => $course]);

        // Vérifier si déjà acheté
        $alreadyPurchased = false;
        if ($this->getUser()) {
            $alreadyPurchased = $purchaseRepository->findOneBy([
                'utilisateur' => $this->getUser(),
                'course' => $course
            ]) !== null;
        }

        return $this->render('pages/course_detail.html.twig', [
            'course' => $course,
            'lessons' => $lessons,
            'alreadyPurchased' => $alreadyPurchased
        ]);
    }

    #[Route('/lesson/{id}', name: 'app_lesson_detail')]
    public function lessonDetail(int $id, LessonRepository $lessonRepository,PurchaseRepository $purchaseRepository): Response
    {
        $lesson = $lessonRepository->find($id);

        if (!$lesson) {
            throw $this->createNotFoundException('Leçon introuvable.');
        }

        // Vérifier si déjà acheté
        $alreadyPurchased = false;
        if ($this->getUser()) {
            $alreadyPurchased = $purchaseRepository->findOneBy([
                'utilisateur' => $this->getUser(),
                'lesson' => $lesson
            ]) !== null;
    }


        return $this->render('pages/lesson_detail.html.twig', [
            'lesson' => $lesson,
            'alreadyPurchased' => $alreadyPurchased
        ]);
    }

    // ------------------- MODIFIER UN COURS -------------------
    #[Route('/admin/course/{id}/edit', name: 'admin_course_edit')]
    public function editCourse(Request $request, Course $course, EntityManagerInterface $em): Response
    {
        if ($request->isMethod('POST')) {
            $course->setTitle($request->request->get('title'));
            $course->setPrice((float)$request->request->get('price'));
            $em->flush();

            return $this->redirectToRoute('app_admin');
        }

        return $this->render('admin/edit_course.html.twig', [
            'course' => $course
        ]);
    }

    // ------------------- SUPPRIMER UN COURS -------------------
    #[Route('/admin/course/{id}/delete', name: 'admin_course_delete')]
    public function deleteCourse(Course $course, EntityManagerInterface $em): Response
    {
        $em->remove($course);
        $em->flush();

        return $this->redirectToRoute('app_admin');
    }

    // ------------------- MODIFIER UNE LEÇON -------------------
    #[Route('/admin/lesson/{id}/edit', name: 'admin_lesson_edit')]
    public function editLesson(Request $request, Lesson $lesson, EntityManagerInterface $em): Response
    {
        if ($request->isMethod('POST')) {
            $lesson->setTitle($request->request->get('title'));
            $lesson->setPrice((float)$request->request->get('price'));
            $em->flush();

            return $this->redirectToRoute('app_admin');
        }

        return $this->render('admin/edit_lesson.html.twig', [
            'lesson' => $lesson
        ]);
    }

    // ------------------- SUPPRIMER UNE LEÇON -------------------
    #[Route('/admin/lesson/{id}/delete', name: 'admin_lesson_delete')]
    public function deleteLesson(Lesson $lesson, EntityManagerInterface $em): Response
    {
        $em->remove($lesson);
        $em->flush();

        return $this->redirectToRoute('app_admin');
    }

    #[Route('/admin/purchase/{id}/delete', name: 'admin_purchase_delete')]
    public function deletePurchase(Purchase $purchase, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $em->remove($purchase);
        $em->flush();

        $this->addFlash('success', 'Achat supprimé avec succès.');
        return $this->redirectToRoute('app_admin');
    }

    #[Route('/mes-certificats', name: 'app_certificates')]
    public function myCertificates(EntityManagerInterface $em): Response
    {
        $certificates = $em->getRepository(Certificate::class)->findBy([
            'utilisateur' => $this->getUser()
        ]);

        return $this->render('certificate/index.html.twig', [
            'certificates' => $certificates
        ]);
    }

    #[Route('/admin/certificate/{id}/delete', name: 'admin_certificate_delete')]
    public function deleteCertificate(Certificate $certificate, EntityManagerInterface $em): Response
    {
        $em->remove($certificate);
        $em->flush();

        $this->addFlash('success', 'Certificat supprimé avec succès.');
        return $this->redirectToRoute('admin_dashboard');
    }

    #[Route('/certificat/{id}/pdf', name: 'certificate_pdf')]
    public function certificatePdf(Certificate $certificate): Response
    {
        // Vérifier que l’utilisateur est propriétaire ou admin
        $user = $this->getUser();
        if (!$this->isGranted('ROLE_ADMIN') && $certificate->getUtilisateur() !== $user) {
            throw $this->createAccessDeniedException('Accès refusé.');
        }

        // Configurer Dompdf
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($options);

        // Générer HTML du certificat
        $html = $this->renderView('certificate/pdf.html.twig', [
            'certificate' => $certificate
        ]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        // Retourner le PDF en téléchargement
        return new Response(
            $dompdf->output(),
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="certificat-'.$certificate->getId().'.pdf"'
        ]
        );
    }

}
