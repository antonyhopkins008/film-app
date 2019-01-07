<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    const USERS = [
        [
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => 'test',
            'roles' => [User::ROLE_SUPERADMIN],
            'enabled' => true,
        ],
        [
            'username' => 'typical1',
            'email' => 'antony.hopkins008@gmail.com',
            'password' => 'test',
            'roles' => [User::ROLE_USER],
            'enabled' => true,
        ],
        [
            'username' => 'typical2',
            'email' => 'hpkns008@gmail.com',
            'password' => 'test',
            'roles' => [User::ROLE_USER],
            'enabled' => true,
        ],
        [
            'username' => 'typical3',
            'email' => 'hpkns2008@gmail.com',
            'password' => 'test',
            'roles' => [User::ROLE_USER],
            'enabled' => true,
        ],
        [
            'username' => 'editor',
            'email' => 'editor@gmail.com',
            'password' => 'test',
            'roles' => [User::ROLE_EDITOR],
            'enabled' => true,
        ],
        [
            'username' => 'typical_editor',
            'email' => 'typical_editor@gmail.com',
            'password' => 'test',
            'roles' => [User::ROLE_EDITOR, User::ROLE_USER],
            'enabled' => true,
        ],
    ];
    private $encoder;
    private $faker;

    /**
     * UserFixtures constructor.
     *
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);
    }

    protected function loadUsers(ObjectManager $manager): void
    {
        foreach (self::USERS as $current) {
            $user = new User();
            $user->setEnabled(true);
            $password = $this->encoder->encodePassword($user, $current['password']);
            $user->setPassword($password);
            $user->setUsername($current['username']);
            $user->setEmail($current['email']);
            $user->setRoles($current['roles']);
            $this->addReference('user_'.$user->getUsername(), $user);
            $manager->persist($user);
        }

        $manager->flush();
    }
}
