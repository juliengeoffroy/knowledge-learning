<?php

namespace App\Controller;

use App\Entity\Certificate;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CertificateRepository;

class CertificateController extends AbstractController
{
    #[Route('/certifications', name: 'app_certifications')]
    public function list(CertificateRepository $certificateRepository): Response
    {
        $user = $this->getUser();

        // Si l'utilisateur n'est pas connecté, on le redirige vers la page de login
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $certificates = $certificateRepository->findBy(['utilisateur' => $user]);

        return $this->render('certificate/index.html.twig', [
            'certificates' => $certificates,
        ]);
    }


    #[Route('/certificate/{id}/pdf', name: 'certificate_pdf')]
    public function download(Certificate $certificate): Response
    {
        $user = $this->getUser();

        // Vérification d'accès
        if (!$this->isGranted('ROLE_ADMIN') && $certificate->getUtilisateur() !== $user) {
            throw $this->createAccessDeniedException('Accès refusé au certificat.');
        }

        $html = $this->renderView('certificate/pdf.html.twig', [
            'cert' => $certificate,
        ]);

        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        return new Response($dompdf->stream("certificat_{$certificate->getId()}.pdf", [
            'Attachment' => true
        ]));
    }


}
