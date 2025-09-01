<?php

namespace App\Tests\Entity;

use App\Entity\Progress;
use App\Entity\Lesson;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class ProgressTest extends TestCase
{
    public function testProgressProperties()
    {
        $progress = new Progress();
        $lesson = new Lesson();
        $user = new User();
        $date = new \DateTimeImmutable();

        $progress->setLesson($lesson);
        $progress->setUtilisateur($user);
        $progress->setPercentage(100);
        $progress->setCompletedAt($date);
        $progress->setCreatedAt($date);

        $this->assertSame($lesson, $progress->getLesson());
        $this->assertSame($user, $progress->getUtilisateur());
        $this->assertEquals(100, $progress->getPercentage());
        $this->assertSame($date, $progress->getCompletedAt());
        $this->assertSame($date, $progress->getCreatedAt());
    }
}
