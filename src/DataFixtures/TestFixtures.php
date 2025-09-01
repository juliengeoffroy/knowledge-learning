<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Theme;
use App\Entity\Course;
use App\Entity\Lesson;
use App\Entity\Progress;
use App\Entity\Certificate;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class TestFixtures extends Fixture implements FixtureGroupInterface
{
    public static function getGroups(): array
    {
        return ['test'];
    }

    public function load(ObjectManager $manager): void
    {
        $now = new \DateTimeImmutable();

        // Utilisateur test
        $user = new User();
        $user->setEmail('admin@kl.com');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword('password');
        $user->setIsVerified(true);
        $user->setCreatedAt($now);
        $manager->persist($user);

        // Thème test
        $theme = new Theme();
        $theme->setTitle('Musique');
        $theme->setDescription('Cours de guitare et piano');
        $theme->setCreatedAt($now);
        $manager->persist($theme);

        // Cours test
        $course = new Course();
        $course->setTitle('Guitare Débutant');
        $course->setPrice(49.99);
        $course->setTheme($theme);
        $course->setCreatedAt($now);
        $manager->persist($course);

        // Leçon test
        $lesson = new Lesson();
        $lesson->setTitle('Accords de base');
        $lesson->setContent('Contenu introductif');
        $lesson->setPrice(9.99);
        $lesson->setPosition(1);
        $lesson->setCourse($course);
        $lesson->setCreatedAt($now);
        $manager->persist($lesson);

        // Progression à 100%
        $progress = new Progress();
        $progress->setLesson($lesson);
        $progress->setUtilisateur($user);
        $progress->setPercentage(100);
        $progress->setCompletedAt($now);
        $progress->setCreatedAt($now);
        $manager->persist($progress);

        // Certificat
        $certificate = new Certificate();
        $certificate->setUtilisateur($user);
        $certificate->setCourse($course);
        $certificate->setCreatedAt($now);
        $manager->persist($certificate);

        $manager->flush();
    }
}
