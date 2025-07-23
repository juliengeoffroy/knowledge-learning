<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\CourseRepository;
use App\Repository\LessonRepository;
use App\Repository\PurchaseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    #[Route('/courses', name: 'app_courses')]
    public function courses(): Response
    {
        return $this->render('pages/courses.html.twig');
    }

    #[Route('/my-courses', name: 'app_my_courses')]
    public function myCourses(): Response
    {
        $courses = [
            ['title' => 'Cursus guitare', 'progress' => 50],
            ['title' => 'Cursus développement web', 'progress' => 20],
            ['title' => 'Cursus cuisine', 'progress' => 100],
        ];

        $certifications = [
            ['title' => 'Cursus cuisine', 'date' => '2025-07-20']
        ];

        return $this->render('pages/my_courses.html.twig', [
            'courses' => $courses,
            'certifications' => $certifications
        ]);
    }

    #[Route('/certifications', name: 'app_certifications')]
    public function certifications(): Response
    {
        return $this->render('pages/certifications.html.twig');
    }

    #[Route('/admin', name: 'app_admin')]
    public function admin(UserRepository $userRepository, CourseRepository $courseRepository,PurchaseRepository $purchaseRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $users = $userRepository->findAll();
        $courses = $courseRepository->findAll();
        $purchases = $purchaseRepository->findAll();

        return $this->render('pages/admin.html.twig', [
            'users' => $users,
            'courses' => $courses,
            'purchases' => $purchases
        ]);
    }
    #[Route('/courses/{id}', name: 'app_course_detail')]
    public function courseDetail(int $id, CourseRepository $courseRepository, LessonRepository $lessonRepository): Response
    {
        $course = $courseRepository->find($id);

        if (!$course) {
            throw $this->createNotFoundException('Cours introuvable.');
        }

        // Récupérer les leçons liées
        $lessons = $lessonRepository->findBy(['course' => $course]);

        return $this->render('pages/course_detail.html.twig', [
            'course' => $course,
            'lessons' => $lessons
        ]);
    }

    #[Route('/lesson/{id}', name: 'app_lesson_detail')]
    public function lessonDetail(int $id, LessonRepository $lessonRepository): Response
    {
        $lesson = $lessonRepository->find($id);

        if (!$lesson) {
            throw $this->createNotFoundException('Leçon introuvable.');
        }

        return $this->render('pages/lesson_detail.html.twig', [
            'lesson' => $lesson
        ]);
    }

}
