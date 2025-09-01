<?php

namespace App\Tests\Entity;

use App\Entity\Lesson;
use App\Entity\Course;
use PHPUnit\Framework\TestCase;

class LessonTest extends TestCase
{
    public function testLessonProperties()
    {
        $lesson = new Lesson();
        $course = new Course();

        $lesson->setTitle('Introduction');
        $lesson->setPrice(19.99);
        $lesson->setContent('Contenu test');
        $lesson->setPosition(1);
        $lesson->setCourse($course);
        $lesson->setCreatedAt(new \DateTimeImmutable());

        $this->assertEquals('Introduction', $lesson->getTitle());
        $this->assertEquals(19.99, $lesson->getPrice());
        $this->assertEquals('Contenu test', $lesson->getContent());
        $this->assertEquals(1, $lesson->getPosition());
        $this->assertSame($course, $lesson->getCourse());
        $this->assertInstanceOf(\DateTimeImmutable::class, $lesson->getCreatedAt());
    }
}
