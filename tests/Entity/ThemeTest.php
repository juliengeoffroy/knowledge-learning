<?php

namespace App\Tests\Entity;

use App\Entity\Theme;
use PHPUnit\Framework\TestCase;

class ThemeTest extends TestCase
{
    public function testThemeProperties()
    {
        $theme = new Theme();
        $theme->setTitle('Cuisine');
        $theme->setDescription('Cours de cuisine complets');
        $theme->setCreatedAt(new \DateTimeImmutable());

        $this->assertEquals('Cuisine', $theme->getTitle());
        $this->assertEquals('Cours de cuisine complets', $theme->getDescription());
        $this->assertInstanceOf(\DateTimeImmutable::class, $theme->getCreatedAt());
    }
}
