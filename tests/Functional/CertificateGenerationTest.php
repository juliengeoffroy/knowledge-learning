<?php

namespace App\Tests\Functional;

use App\Entity\Progress;
use App\Entity\Certificate;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CertificateGenerationTest extends KernelTestCase
{
    public function testCertificateGeneratedWhenProgressComplete(): void
    {
        self::bootKernel();
        $em = static::getContainer()->get('doctrine')->getManager();

        $progressRepo = $em->getRepository(Progress::class);
        $certRepo = $em->getRepository(Certificate::class);

        $progress = $progressRepo->findOneBy(['percentage' => 100]);
        $this->assertNotNull($progress, 'Aucune progression à 100% trouvée');

        $certificate = $certRepo->findOneBy([
            'user' => $progress->getUtilisateur(),
            'course' => $progress->getCourse()
        ]);

        $this->assertNotNull($certificate, 'Aucun certificat trouvé pour ce user/course');
        $this->assertEquals($progress->getUtilisateur(), $certificate->getUtilisateur());
    }
}
