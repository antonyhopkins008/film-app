<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use App\Entity\Film;
use App\Entity\Genre;
use App\Entity\Producer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class FilmFixtures extends Fixture implements DependentFixtureInterface
{
    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager)
    {
        $this->loadFilms($manager);
    }

    private function loadFilms(ObjectManager $manager)
    {
        for ($i = 0; $i < 100; ++$i) {
            $film = new Film();
            $film->setTitle($this->faker->realText(50));
            $film->setCountry($this->faker->country);
            $film->setBudget($this->faker->randomFloat(2, 1, 100));
            $film->setDuration($this->getRandomFilmDuration());
            $film->setHasSubtitles(true);
            $film->setPosterImg($this->faker->imageUrl());
            $film->setDescription($this->faker->text(300));
            $film->setReleaseYear(mt_rand(1990, 2018));
            $film->setSourcePath($this->faker->url);

            $index = mt_rand(0, 9);
            /** @var Producer $producer */
            $producer = $this->getReference("producer_{$index}");
            $film->setProducer($producer);

            $index = mt_rand(0, 19);
            /** @var Actor $actor */
            $actor = $this->getReference("actor_{$index}");
            $film->setActor($actor);

            $this->setGenres($film);
            $this->setActors($film);

            $this->setReference("film_{$i}", $film);
            $manager->persist($film);
        }
        $manager->flush();
    }

    /**
     * One hour + minutes as integer round number.
     *
     * @return int Seconds
     */
    private function getRandomFilmDuration(): int
    {
        return 60 * 60 + 60 * (array_rand([10, 20, 30, 40, 50]));
    }

    private function setGenres(Film $film): void
    {
        $rand = mt_rand(0, 5);
        for ($genreIdx = 0; $genreIdx <= $rand; ++$genreIdx) {
            $genreName = GenreFixtures::GENRES[mt_rand(0, 5)];

            /** @var Genre $genre */
            $genre = $this->getReference("genre_{$genreName}");
            $film->setGenre($genre);
        }
    }

    private function setActors(Film $film): void
    {
        $actorsCount = mt_rand(1, 8);
        for ($actorIdx = 0; $actorIdx <= $actorsCount; ++$actorIdx) {
            $randActorIdx = mt_rand(0, 19);
            /** @var Actor $actor */
            $actor = $this->getReference("actor_{$randActorIdx}");
            $film->setActor($actor);
        }
    }

    public function getDependencies()
    {
        return [
            ProducerFixture::class,
        ];
    }
}
