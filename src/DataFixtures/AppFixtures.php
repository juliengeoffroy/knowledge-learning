<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Theme;
use App\Entity\Course;
use App\Entity\Lesson;
use App\Entity\Purchase;
use App\Entity\Progress;
use App\Entity\Certificate;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // -------------------
        // Création des utilisateurs
        // -------------------
        $admin = new User();
        $admin->setEmail('admin@kl.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'admin123'));
        $admin->setIsVerified(true);
        $manager->persist($admin);

        $user = new User();
        $user->setEmail('user@kl.com');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword($this->passwordHasher->hashPassword($user, 'user123'));
        $user->setIsVerified(true);
        $manager->persist($user);

        // -------------------
        // Thèmes et cours
        // -------------------
        $themesData = [
            [
                'title' => 'Musique',
                'description' => 'Apprenez à jouer de la guitare et du piano pas à pas.',
                'courses' => [
                    ['title' => 'Cursus Guitare', 'price' => 50.0, 'lessons' => [
                        ['title' => 'Découverte de la guitare', 'price' => 10.0, 'content' => 'Présentation des cordes, accordage et tenue de l’instrument.'],
                        ['title' => 'Les accords de base', 'price' => 15.0, 'content' => 'Apprenez les accords majeurs et mineurs pour débuter.']
                    ]],
                    ['title' => 'Cursus Piano', 'price' => 50.0, 'lessons' => [
                        ['title' => 'Découverte du piano', 'price' => 10.0, 'content' => 'Présentation des touches et posture.'],
                        ['title' => 'Les gammes de base', 'price' => 15.0, 'content' => 'Apprenez les gammes majeures et mineures.']
                    ]]
                ]
            ],
            [
                'title' => 'Cuisine',
                'description' => 'Découvrez la cuisine et le dressage culinaire.',
                'courses' => [
                    ['title' => 'Cursus Cuisine', 'price' => 44.0, 'lessons' => [
                        ['title' => 'Modes de cuisson', 'price' => 12.0, 'content' => 'Cuire à la vapeur, au four et à la poêle.'],
                        ['title' => 'Association des saveurs', 'price' => 14.0, 'content' => 'Marier les saveurs pour sublimer vos plats.']
                    ]],
                    ['title' => 'Cursus Dressage Culinaire', 'price' => 48.0, 'lessons' => [
                        ['title' => 'Dressage des assiettes', 'price' => 10.0, 'content' => 'Disposition esthétique des aliments.'],
                        ['title' => 'Harmonisation d’un repas', 'price' => 15.0, 'content' => 'Créer un menu équilibré et visuel.']
                    ]]
                ]
            ],
            [
                'title' => 'Informatique',
                'description' => 'Apprenez le développement web (HTML, CSS, JavaScript).',
                'courses' => [
                    ['title' => 'Cursus Développement Web', 'price' => 60.0, 'lessons' => [
                        ['title' => 'HTML & CSS', 'price' => 20.0, 'content' => 'Bases pour créer des pages web structurées et stylisées.'],
                        ['title' => 'JavaScript dynamique', 'price' => 25.0, 'content' => 'Apprenez l’interactivité côté client.']
                    ]]
                ]
            ],
            [
                'title' => 'Jardinage',
                'description' => 'Initiez-vous aux techniques de jardinage et calendrier lunaire.',
                'courses' => [
                    ['title' => 'Cursus Jardinage', 'price' => 30.0, 'lessons' => [
                        ['title' => 'Outils du jardinier', 'price' => 8.0, 'content' => 'Présentation des outils et leur entretien.'],
                        ['title' => 'Jardiner avec la lune', 'price' => 12.0, 'content' => 'Planter selon le calendrier lunaire.']
                    ]]
                ]
            ]
        ];

        $allCourses = [];

        foreach ($themesData as $themeData) {
            $theme = new Theme();
            $theme->setTitle($themeData['title']);
            $theme->setDescription($themeData['description']);


            $manager->persist($theme);

            foreach ($themeData['courses'] as $courseData) {
                $course = new Course();
                $course->setTitle($courseData['title']);
                $course->setPrice($courseData['price']);
                $course->setTheme($theme);
                $manager->persist($course);
                $allCourses[] = $course;

                foreach ($courseData['lessons'] as $lessonData) {
                    $lesson = new Lesson();
                    $lesson->setTitle($lessonData['title']);
                    $lesson->setPrice($lessonData['price']);
                    $lesson->setContent($lessonData['content']);
                    $lesson->setCourse($course);


                    $manager->persist($lesson);
                }
            }
        }

        // -------------------
        // Exemple d’achat + certificat
        // -------------------
        $purchase = new Purchase();
        $purchase->setUtilisateur($user);
        $purchase->setCourse($course); // Premier cours Musique
        $purchase->setLesson($lesson);
        $purchase->setPurchasedAt(new \DateTimeImmutable());
        $manager->persist($purchase);

        $certificate = new Certificate();
        $certificate->setUtilisateur($user);
        $certificate->setCourse($allCourses[0]);
        $certificate->setObtainedAt(new \DateTime());
        $manager->persist($certificate);

        $progress = new Progress();
        $progress->setUtilisateur($user);
        $progress->setLesson($lesson);
        $progress->setPercentage(0);
        $progress->setCompletedAt(new \DateTimeImmutable());
        $manager->persist($progress);

        $manager->flush();
    }
}
