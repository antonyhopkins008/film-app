<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class ActorFixtures extends Fixture
{
    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager)
    {
        $this->loadActors($manager);
    }

    private function loadActors(ObjectManager $manager)
    {
        for ($i = 0; $i < 20; ++$i) {
            $actor = new Actor();
            $actor->setFirstName($this->faker->firstName);
            $actor->setLastName($this->faker->lastName);
            $this->setReference("actor_{$i}", $actor);

            $manager->persist($actor);
        }
        $manager->flush();
    }
}
