<?php

namespace App\DataFixtures;

use App\Entity\Tuteur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface; // 👈 Nouvelle use

class TuteurFixture extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher; 

    // Injection du service de hachage de mot de passe via le constructeur
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $tuteur = new Tuteur();
        $tuteur->setNom('Tuteur');
        $tuteur->setPrenom('Test');
        $tuteur->setEmail('test@example.com');
        $tuteur->setTelephone('0123456789');
        $tuteur->setEntreprise('DemoTech'); 

        // Hachage du mot de passe 'password'
        $hashedPassword = $this->passwordHasher->hashPassword(
            $tuteur,
            'password' 
        );
        $tuteur->setPassword($hashedPassword);

        $manager->persist($tuteur);
        $manager->flush();

        $this->addReference('tuteur_test', $tuteur); 
    }
}
