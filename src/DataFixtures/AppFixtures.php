<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Medecin;
use App\Entity\Rapport;
use App\Entity\Visiteur;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        //Créer 3 medecin avec Faker
        for ($i = 1; $i <=3; $i++){
            $medecin = new Medecin();
            $medecin->setNom($faker->lastname())
                    ->setPrenom($faker->firstname())
                    ->setVille($faker->city());
            $manager->persist($medecin);
        
        //Créer 3 visiteurs avec Faker
        for ($j = 1; $j <=4; $j++){
            $visiteur = new Visiteur();
            $visiteur->setNom($faker->lastname())
                     ->setPrenom($faker->firstname())
                     ->setMedecin($medecin);
            $manager->persist($visiteur);
        }
        for ($r = 1; $r <=mt_rand(4,6); $r++){
            $rapport = new Rapport();
            $bilan = '<p>'. join($faker->paragraphs(5), '</p><p>').'</p>';
            $rapport->setBilan($bilan)
                    ->setDate($faker->dateTimeBetween('-6 months'))
                    ->setVisiteur($visiteur)
                    ->setMedecin($medecin);
            $manager->persist($rapport);

        }
        }
        

        $manager->flush();
    }
}
