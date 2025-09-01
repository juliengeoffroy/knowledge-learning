<?php

namespace App\Tests\Entity;

use App\Entity\Certificate;
use App\Entity\User;
use App\Entity\Course;
use PHPUnit\Framework\TestCase;

class CertificateTest extends TestCase
{
    public function testCertificateProperties()
    {
        $user = new User();
        $course = new Course();
        $certificate = new Certificate();

        $certificate->setUtilisateur($user);
        $certificate->setCourse($course);
        $certificate->setObtainedAt(new \DateTime('2025-08-28'));

        $this->assertEquals($user, $certificate->getUtilisateur());
        $this->assertEquals($course, $certificate->getCourse());
        $this->assertInstanceOf(\DateTimeInterface::class, $certificate->getObtainedAt());
    }
}
