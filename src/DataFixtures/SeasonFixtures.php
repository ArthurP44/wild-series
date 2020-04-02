<?php


namespace App\DataFixtures;


use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for($i =0; $i < 25; $i++ )
        {
            $season = new Season();
            $faker  =  Faker\Factory::create('fr_FR');
            $season->setNumber($faker->randomDigit);
            $season->setYear($faker->year);
            $season->setDescription(mb_strtolower($faker->text));
            $this->addReference('season_' . $i, $season);

            $manager->persist($season);

            $season->setProgram($this->getReference('program_0'));
        }
        $manager->flush();
    }
    public function getDependencies()
    {
        return [ProgramFixtures::class];
    }
}