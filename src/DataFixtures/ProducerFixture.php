<?php

namespace App\DataFixtures;

use App\Entity\Producer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class ProducerFixture extends Fixture
{
    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager)
    {
        $this->loadProducers($manager);
    }

    private function loadProducers(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; ++$i) {
            $producer = new Producer();
            $producer->setFirstName($this->faker->firstName);
            $producer->setLastName($this->faker->lastName);
            $this->setReference("producer_{$i}", $producer);
            $manager->persist($producer);
        }
        $manager->flush();
    }
}
