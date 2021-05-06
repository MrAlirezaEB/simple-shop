<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Product;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ProductFixture extends Fixture
{
    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager)
    {
        for($i=0;$i<20;$i++)
        {
            $product = new Product();
            $product->setTitle($this->faker->word());
            $product->setImage('/images/extra/'.rand(1,13).'.jpg');
            $product->setPrice(rand(1,99)*1000);
            $manager->persist($product);
        }

        $manager->flush();
    }
}
