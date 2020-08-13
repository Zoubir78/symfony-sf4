<?php

namespace App\DataFixtures;

use App\Entity\Produit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ProduitFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Instanciation de Faker
        $faker = Factory::create('fr_FR');

        // Générer 50 produits
        for ($i = 0; $i < 50; $i++) {
            $produit = (new Produit())
                ->setNom($faker->realText(50))
                ->setDescription($faker->realText())
                ->setPrix($faker->regexify('\d{2,4}\.\d{2}'))
                ->setQuantite($faker->numberBetween(0, 250))
            ;

            // On prépare à l'enregistrement
            $manager->persist($produit);
        }

        // Enregistrer les 50 entités en base
        $manager->flush();
    }
}
