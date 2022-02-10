<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\User;

class UserFixtures extends Fixture
{


    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create('pl_PL');
        $faker->seed(1234);

        $num=0;
        foreach($this->UserData() as [$email, $pesel]) {
            $user = new User();
            $user->setEmail($email);
            $user->setFirstname($faker->firstName());
            $user->setLastname($faker->lastName());
            $user->setPesel($pesel);            
            $reference = 'user'.$num;
            $this->addReference($reference, $user);
            $num++;
        }
        $manager->flush();
    }



    private function UserData(){
      return [
            ['alex.krol@kaminska.pl', 22050536547],
            ['rozalia.sadowska@wp.pl', 33060458236],
            ['blanka.pawlak@yahoo.com', 88120436547],
            ['przemyslaw.zalewski@wp.pl', 64071458963],
            ['bruno93@kalinowski.pl', 78112569874],
            
    ];  
            
    
    }
}
