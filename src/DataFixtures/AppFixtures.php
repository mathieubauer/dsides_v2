<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Client;
use App\Entity\Project;
use App\Entity\User;
use App\Factory\CategoryFactory;
use App\Factory\ClientFactory;
use App\Factory\ProjectFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
	    UserFactory::createMany(10);
		ClientFactory::createMany(6);
		CategoryFactory::createMany(6);
		ProjectFactory::new()
			->many(10)
			->create(function (){
				return [
					'client' => ClientFactory::random(),
					'category' => CategoryFactory::randomSet(1)
				];
			});
    }
}
