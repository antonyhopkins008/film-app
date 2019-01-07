<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Film;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager)
    {
        $this->loadComments($manager);
    }

    private function loadComments(ObjectManager $manager)
    {
        for ($i = 0; $i < 1000; ++$i) {
            $comment = new Comment();
            $comment->setContent($this->faker->text);

            $randUser = UserFixtures::USERS[mt_rand(1, 3)];
            /** @var User $user */
            $user = $this->getReference("user_{$randUser['username']}");
            $comment->setUser($user);

            $randFilmIdx = mt_rand(0, 99);
            /* @var Film $film */
            $film = $this->getReference("film_{$randFilmIdx}");
            $comment->setFilm($film);
            $manager->persist($comment);
        }

        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on.
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            FilmFixtures::class,
        ];
    }
}
