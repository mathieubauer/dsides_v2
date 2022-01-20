<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Client;
use App\Entity\Project;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    private UserPasswordHasherInterface $encoder;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // users

        $user = new User();
        $user->setEmail('user@demo.fr');
        $password = $this->encoder->hashPassword($user, 'user');
        $user->setPassword($password);
        $manager->persist($user);

        $user = new User();
        $user->setEmail('admin@demo.fr');
        $user->setRoles(array('ROLE_USER', 'ROLE_ADMIN'));
        $password = $this->encoder->hashPassword($user, 'admin');
        $user->setPassword($password);
        $manager->persist($user);

	    // clients
	    for ($j = 0; $j < 3; $j++) {
		    $client = new Client();
		    $client->setName($faker->company());
		    $manager->persist($client);
	    }

	    // categories
	    for ($k = 0; $k < 6; $k++) {
		    $category = new Category();
		    $category->setName($faker->word());
		    $manager->persist($category);
	    }

        // projects
	    for ($i = 0; $i < 10; $i++) {
            $project = new Project();
            $project
                ->setName($faker->words(3, true))
                ->setContent($faker->sentence())
                ->setDisplayOrder($i)
                ->setIsDisplayed($faker->boolean())
                ->setClient($client)
                ->addCategory($category)
                ->setImage('placeholder.jpg');
            $manager->persist($project);
        }

        $manager->flush();
    }
}
