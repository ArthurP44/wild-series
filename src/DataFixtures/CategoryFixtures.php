<?php


namespace App\DataFixtures;


use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    const CATEGORIES = [
        'Action',
        'Animation',
        'Aventure',
        'Comédie',
        'Drame',
        'Fantastique',
        'Fiction',
        'Horreur',

    ];
    public function load(ObjectManager $manager)
    {
        foreach (self::CATEGORIES as $key => $categoryName)
        {
            $category = new Category();
            $category->setName($categoryName);
            $this->addReference('categorie_' . $key, $category);
            $manager->persist($category);

        }
        $manager->flush();
    }
}