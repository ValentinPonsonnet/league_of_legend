<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\News;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
       $this->encoder = $encoder; 
    }
    public function load(ObjectManager $manager): void
    {
        $faker= Faker\Factory::create("fr_FR");
        for($i=0;$i<20;$i++)
        {
            $user = New User();
            $password = $this->encoder->encodePassword($user, 'password');
            $user 
            -> setFirstName($faker->firstName())
            ->setLastName($faker->lastName())
            ->setEmail($faker->email())
            ->setPassword($password); 
            $manager->persist($user);
            for ($j=0; $j< rand (10,50); $j++)
            {
                $news = new News();
                $news
                ->setTitle($faker->title($nbword = 5))
                ->setContent($faker->text())
                ->setStatus($faker->randomElement(["PUBLISH","DISABLED","DRAFT", "DELETED"]))
                ->setImage($faker->imageUrl(550,780, 'animals', true))
                ->setCreatedAt($faker->dateTimeBetween("-1 months", "now", "Europe/Paris"))
                ->setUser($user);
                $manager->persist($news);
            }
        }
        $manager->flush();
    }
}
