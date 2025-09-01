<?php

namespace App\Controller;

use App\Entity\Course;
use App\Entity\Lesson;
use App\Entity\Purchase;
use App\Entity\Certificate; // AJOUT CERTIFICAT
use App\Repository\CourseRepository;
use App\Repository\LessonRepository;
use App\Service\StripeService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class CheckoutController extends AbstractController
{
    /**
     * ACHAT D'UN COURS
     */
    #[Route('/checkout/course/{id}', name: 'checkout_course')]
    #[IsGranted('ROLE_USER')]
    public function checkoutCourse(
        int $id,
        CourseRepository $courseRepo,
        StripeService $stripeService
    ): Response {
        $course = $courseRepo->find($id);

        if (!$course) {
            throw $this->createNotFoundException('Cours introuvable');
        }

        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        if (!$user || !$user->isVerified()) {
            $this->addFlash('error', 'Veuillez confirmer votre email avant de procéder à un achat.');
            return $this->redirectToRoute('app_home');
        }

        // Créer la session Stripe
        $session = $stripeService->createCheckoutSession([
            'productName' => $course->getTitle(),
            'price' => $course->getPrice(),
            'successUrl' => $this->generateUrl('checkout_success', [
                'type' => 'course',
                'id'   => $course->getId()
            ], 0),
            'cancelUrl' => $this->generateUrl('checkout_cancel', [], 0),
        ]);

        return new RedirectResponse($session->url, 303);
    }

    /**
     * ACHAT D'UNE LEÇON
     */
    #[Route('/checkout/lesson/{id}', name: 'checkout_lesson')]
    #[IsGranted('ROLE_USER')]
    public function checkoutLesson(
        int $id,
        LessonRepository $lessonRepo,
        StripeService $stripeService
    ): Response {
        $lesson = $lessonRepo->find($id);

        if (!$lesson) {
            throw $this->createNotFoundException('Leçon introuvable');
        }

        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        if (!$user || !$user->isVerified()) {
            $this->addFlash('error', 'Veuillez confirmer votre email avant de procéder à un achat.');
            return $this->redirectToRoute('app_home');
        }

        // Créer la session Stripe
        $session = $stripeService->createCheckoutSession([
            'productName' => $lesson->getTitle(),
            'price' => $lesson->getPrice(),
            'successUrl' => $this->generateUrl('checkout_success', [
                'type' => 'lesson',
                'id'   => $lesson->getId()
            ], 0),
            'cancelUrl' => $this->generateUrl('checkout_cancel', [], 0),
        ]);

        return new RedirectResponse($session->url, 303);
    }

    /**
     * SUCCÈS DE PAIEMENT → ENREGISTRE L'ACHAT
     */
    #[Route('/checkout/success', name: 'checkout_success')]
    public function success(
        Request $request,
        CourseRepository $courseRepo,
        LessonRepository $lessonRepo,
        EntityManagerInterface $em
    ): Response {
        $type = $request->query->get('type');
        $id = $request->query->get('id');
        $user = $this->getUser();

        if (!$user) {
            $this->addFlash('error', 'Vous devez être connecté pour voir vos achats.');
            return $this->redirectToRoute('app_login');
        }

        // Créer un nouvel achat
        $purchase = new Purchase();
        $purchase->setUtilisateur($user);
        $purchase->setPurchasedAt(new \DateTimeImmutable());
        $purchase->setCreatedAt(new \DateTimeImmutable());

        // Lier le cours ou la leçon
        if ($type === 'course') {
            $course = $courseRepo->find($id);
            if ($course) {
                $purchase->setCourse($course);
                $purchase->setPrice($course->getPrice());

                // AJOUT CERTIFICAT : Créer automatiquement le certificat
                $certificate = new Certificate();
                $certificate->setUtilisateur($user);
                $certificate->setCourse($course);
                $certificate->setObtainedAt(new \DateTimeImmutable());
                $em->persist($certificate);
                $em->flush();
            }
        } elseif ($type === 'lesson') {
            $lesson = $lessonRepo->find($id);
            if ($lesson) {
                $purchase->setLesson($lesson);
                $purchase->setPrice($lesson->getPrice());
            }
        }

        // Sauvegarder en base
        $em->persist($purchase);
        $em->flush();

        // Message de confirmation
        $this->addFlash('success', 'Paiement réussi ! Vous avez accès à votre contenu.');

        return $this->redirectToRoute('app_my_courses');
    }

    /**
     * ANNULATION DE PAIEMENT
     */
    #[Route('/checkout/cancel', name: 'checkout_cancel')]
    public function cancel(): Response
    {
        $this->addFlash('error', 'Le paiement a été annulé.');
        return $this->redirectToRoute('app_home');
    }
}


