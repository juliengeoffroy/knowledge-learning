<?php

namespace App\Tests\Repository;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserRepositoryTest extends KernelTestCase
{
    public function testFindUserByEmail(): void
    {
        self::bootKernel();
        $userRepository = static::getContainer()->get('doctrine')->getRepository(User::class);

        $user = $userRepository->findOneByEmail('admin@kl.com');
        $this->assertInstanceOf(User::class, $user);
    }
}
