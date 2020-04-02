<?php


namespace App\DataFixtures;


use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class EpisodeFixtures extends Fixture
{
   public function load(ObjectManager $manager)
   {
       for($i =0; $i < 25; $i++ )
       {
           $episode = new Episode();
           $faker  =  Faker\Factory::create('fr_FR');
           $episode->setTitle(mb_strtolower($faker->sentence()));
           $episode->setNumber($faker->randomDigit);
           $episode->setSynopsis(mb_strtolower($faker->text));
           $manager->persist($episode);

           $episode->setSeason($this->getReference('season_16'));
       }
       $manager->flush();
   }

    public function getDependencies()
    {
        return [SeasonFixtures::class];
    }
}