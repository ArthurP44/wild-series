<?php


namespace App\DataFixtures;


use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;


class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    const ACTORS = [
        'Jean Dujardin',
        'Ewan Mc Gregor',
        'Bill Murray',
        'Eddie Murphy',
        'Elijah Wood',
        'Simon Peg',
        'Nick Wilhom',
        'Eva Green',
    ];


    public function load(ObjectManager $manager)
    {
        foreach (self::ACTORS as $key => $actorName) {
            $actor = new Actor();
            $actor->setName($actorName);
            $this->addReference('actor_' . $key, $actor);
            $manager->persist($actor);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [ProgramFixtures::class];
    }
}