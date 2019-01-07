<?php

namespace App\DataFixtures;

use App\Entity\Genre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class GenreFixtures extends Fixture
{
    const GENRES = [
        'ACTION',
        'ADVENTURE',
        'COMEDY',
        'CRIME_AND_GANGSTER',
        'DRAMA',
        'HISTORICAL',
        'MISICAL',
        'SCIENCE',
        'WAR',
        'WESTERN',
    ];

    public function load(ObjectManager $manager)
    {
        $this->loadGenres($manager);
    }

    private function loadGenres(ObjectManager $manager)
    {
        foreach (self::GENRES as $genreName) {
            $genre = new Genre();
            $genre->setName($genreName);
            $this->setReference("genre_{$genreName}", $genre);
            $manager->persist($genre);
        }

        $manager->flush();
    }
}
