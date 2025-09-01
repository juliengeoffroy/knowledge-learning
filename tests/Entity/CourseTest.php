<?php

namespace App\Tests\Entity;

use App\Entity\Course;
use App\Entity\Theme;
use PHPUnit\Framework\TestCase;


class CourseTest extends TestCase
{
    public function testCourseProperties()
    {
        $course = new Course();
        $theme = new Theme();

        $course->setTitle('Cours PHP');
        $course->setPrice(49.99);
        $course->setTheme($theme);
        $course->setCreatedAt(new \DateTimeImmutable());

        $this->assertEquals('Cours PHP', $course->getTitle());
        $this->assertEquals(49.99, $course->getPrice());
        $this->assertEquals($theme, $course->getTheme());
        $this->assertInstanceOf(\DateTimeImmutable::class, $course->getCreatedAt());
    }
}
