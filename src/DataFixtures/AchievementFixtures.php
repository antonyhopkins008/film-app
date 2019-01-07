<?php

namespace App\DataFixtures;

use App\Entity\Achievement;
use App\Entity\Film;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class AchievementFixtures extends Fixture implements DependentFixtureInterface
{
    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager)
    {
        $this->loadAchievements($manager);
    }

    private function loadAchievements(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; ++$i) {
            $achievement = new Achievement();
            $achievement->setName($this->faker->company);
            $achievement->setCountry($this->faker->country);

            for ($filmIdx = 0; $filmIdx < 70; ++$filmIdx) {
                $rand = mt_rand(0, 70);
                /** @var Film $film */
                $film = $this->getReference("film_{$rand}");
                $achievement->setFilm($film);
            }

            $manager->persist($achievement);
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
