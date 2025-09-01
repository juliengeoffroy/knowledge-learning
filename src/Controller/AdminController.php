<?php

namespace App\Controller;

use App\Entity\Course;
use App\Entity\Lesson;
use App\Form\CourseType;
use App\Form\LessonType;
use App\Repository\UserRepository;
use App\Repository\CourseRepository;
use App\Repository\LessonRepository;
use App\Repository\PurchaseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(
        UserRepository $userRepository,
        CourseRepository $courseRepository,
        LessonRepository $lessonRepository,
        PurchaseRepository $purchaseRepository
    ): Response {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('pages/admin.html.twig', [
            'users' => $userRepository->findAll(),
            'courses' => $courseRepository->findAll(),
            'lessons' => $lessonRepository->findAll(),
            'purchases' => $purchaseRepository->findAll(),
        ]);
    }

    // === SUPPRIMER UN COURS ===
    #[Route('/admin/course/{id}/delete', name: 'admin_course_delete')]
    public function deleteCourse(Course $course, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $em->remove($course);
        $em->flush();

        $this->addFlash('success', 'Le cours a été supprimé avec succès.');
        return $this->redirectToRoute('app_admin');
    }

    // === SUPPRIMER UNE LEÇON ===
    #[Route('/admin/lesson/{id}/delete', name: 'admin_lesson_delete')]
    public function deleteLesson(Lesson $lesson, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $em->remove($lesson);
        $em->flush();

        $this->addFlash('success', 'La leçon a été supprimée avec succès.');
        return $this->redirectToRoute('app_admin');
    }

    // === MODIFIER UN COURS ===
    #[Route('/admin/course/{id}/edit', name: 'admin_course_edit')]
    public function editCourse(Request $request, Course $course, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Cours modifié avec succès.');
            return $this->redirectToRoute('app_admin');
        }

        return $this->render('admin/edit_course.html.twig', [
            'form' => $form->createView(),
            'course' => $course
        ]);
    }

    // === MODIFIER UNE LEÇON ===
    #[Route('/admin/lesson/{id}/edit', name: 'admin_lesson_edit')]
    public function editLesson(Request $request, Lesson $lesson, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(LessonType::class, $lesson);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Leçon modifiée avec succès.');
            return $this->redirectToRoute('app_admin');
        }

        return $this->render('admin/edit_lesson.html.twig', [
            'form' => $form->createView(),
            'lesson' => $lesson
        ]);
    }
}
