<?php

namespace App\Tests\Entity;

use App\Entity\Purchase;
use App\Entity\User;
use App\Entity\Course;
use App\Entity\Lesson;
use PHPUnit\Framework\TestCase;

class PurchaseTest extends TestCase
{
    public function testPurchaseProperties()
    {
        $purchase = new Purchase();
        $user = new User();
        $course = new Course();
        $lesson = new Lesson();
        $date = new \DateTimeImmutable();

        $purchase->setUtilisateur($user);
        $purchase->setCourse($course);
        $purchase->setLesson($lesson);
        $purchase->setPurchasedAt($date);

        $this->assertSame($user, $purchase->getUtilisateur());
        $this->assertSame($course, $purchase->getCourse());
        $this->assertSame($lesson, $purchase->getLesson());
        $this->assertSame($date, $purchase->getPurchasedAt());
    }
}
