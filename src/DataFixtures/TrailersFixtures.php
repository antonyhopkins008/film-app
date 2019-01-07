<?php

namespace App\DataFixtures;

use App\Entity\Film;
use App\Entity\Trailer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class TrailersFixtures extends Fixture implements DependentFixtureInterface
{
    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager)
    {
        $this->loadTrailers($manager);
    }

    private function loadTrailers(ObjectManager $manager)
    {
        for ($i = 0; $i < 200; ++$i) {
            $trailer = new Trailer();
            $trailer->setDuration(60 * 60 + 60 * array_rand([10, 20, 30, 40, 50]));
            $trailer->setTitle($this->faker->title);
            $rand = mt_rand(0, 99);
            /** @var Film $film */
            $film = $this->getReference("film_{$rand}");
            $trailer->setFilm($film);
            $trailer->setSourcePath($this->faker->url);
            $manager->persist($trailer);
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
