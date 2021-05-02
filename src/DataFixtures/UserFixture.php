<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends Fixture
{
    private $passwordEncoder;
    private $faker;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setBirthday(new \DateTime('1996-02-19'));
        $user->setEmail('mr.alireza.eb@gmail.com');
        $user->setMobile('09034034103');
        $user->setRoles(['ROLE_ADMIN']);
        $user->setFullname('علیرضا ابراهیم زاده');
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'a123456789'
        ));
        $manager->persist($user);
        $manager->flush();
    }
}
