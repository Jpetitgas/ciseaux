<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Entity\DetailFacture;
use App\Entity\Facture;
use App\Entity\MoyenPaiement;
use App\Entity\Prestation;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    protected $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $user = new User();
        $hash = $this->encoder->encodePassword($user, 'password');
        $user->setUsername('admin')
            ->setPassword($hash)
            ->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);

        $service = new Prestation();
        $service->setTypeDePrestation('Prestation de services');
        $manager->persist($service);
        $vente = new Prestation();
        $vente->setTypeDePrestation('Vente');
        $manager->persist($vente);

        $cheque = new MoyenPaiement();
        $cheque->setTypeDePaiement('Cheque');
        $manager->persist($cheque);
        $liquide = new MoyenPaiement();
        $liquide->setTypeDePaiement('Liquide');
        $manager->persist($liquide);

        for ($cl = 0; $cl <= 50; ++$cl) {
            $client = new Client();
            $client->setNom($faker->firstName());
            $client->setPrenom($faker->lastName());
            $client->setAdresse($faker->streetAddress);
            $client->setCodepostal(rand(63000, 64000));
            $client->setVille($faker->city);
            $manager->persist($client);
            for ($fac = 0; $fac <= 20; ++$fac) {
                $facture = new Facture();
                $facture->setClient($client);
                $facture->setDate($faker->dateTimeBetween());
                $hasard = rand(0, 1);
                if (($hasard == 0) ? $facture->setTypeDePaiement($liquide) : $facture->setTypeDePaiement($cheque));
                $manager->persist($facture);
                $rand = rand(5, 10);
                for ($det = 0; $det <= $rand; ++$det) {
                    $detail = new DetailFacture();
                    $detail->setDesignation($faker->sentence());
                    $detail->setFacture($facture);
                    $detail->setPrix(rand(5, 50));
                    $hasard = rand(0, 1);
                    if (($hasard == 0) ? $detail->setTypePrestation($service) : $detail->setTypePrestation($vente));
                    $manager->persist($detail);
                }
            }
        }

        $manager->flush();
    }
}
