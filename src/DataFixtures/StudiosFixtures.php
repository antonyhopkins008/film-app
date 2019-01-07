<?php

namespace App\DataFixtures;

use App\Entity\Film;
use App\Entity\Studio;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class StudiosFixtures extends Fixture implements DependentFixtureInterface
{
    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager)
    {
        $this->loadStudios($manager);
    }

    private function loadStudios(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; ++$i) {
            $studio = new Studio();
            $studio->setCountry($this->faker->country);
            $studio->setName($this->faker->company);

            for ($filmIdx = 0; $filmIdx < 70; ++$filmIdx) {
                $rand = mt_rand(0, 40);
                /** @var Film $film */
                $film = $this->getReference("film_{$rand}");
                $studio->setFilm($film);
            }

            $manager->persist($studio);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            FilmFixtures::class,
        ];
    }
}
