<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Company;
use Faker\Factory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CompanyFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {


        $num=10;
        // $faker = Factory::create();
        
        $faker = Factory::create('pl_PL');
        $faker->seed(1234);

        for($i=0; $i<$num; $i++) {
            $company = new Company();
            $company->setCreatedBy($this->getReference('user'.rand(0,4)));
            $company->setNip($faker->taxpayerIdentificationNumber());
            $company->setName($faker->company());
            $company->setStreet($faker->streetName());
            $company->setHouseNr($faker->buildingNumber());
            $company->setFlatNr(rand(1,100));
            $company->setPostcode($faker->postcode());
            $company->setPlace($faker->city());
            $company->setPhone($faker->randomNumber(9, true));
            $company->setEmail($faker->email());
            
            $manager->persist($company);
            
        }

        // $product->setCreatedBy($this->getReference('user'));
        // $this->addReference('product', $product);

        $manager->flush();
    }


    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}
