<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $generator  = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setLogin($generator->email())
                ->setApiKey($generator->md5());
            $manager->persist($user);
        }

        $manager->flush();
    }
}
