<?php

namespace App\Command;

use App\Entity\Tuteur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:create-tuteur',
    description: 'Creates a Tuteur user for testing purposes.',
)]
class CreateTuteurCommand extends Command
{
    private EntityManagerInterface $entityManager;
    private UserPasswordHasherInterface $passwordHasher;

    // Injection des services par le constructeur
    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }
    
    // Suppression de la méthode configure() car nous n'avons pas d'arguments
    /* protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    } */

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $tuteur = new Tuteur();
        $tuteur->setEmail('tuteur@app.com');
        $tuteur->setNom('Admin');
        $tuteur->setPrenom('Tuteur');
        $tuteur->setEntreprise('Mon Entreprise Test');
        $tuteur->setTelephone('0123456789');
        $tuteur->setRoles(['ROLE_USER']);
        
        // Hachage correct du mot de passe 'password'
        $hashedPassword = $this->passwordHasher->hashPassword(
            $tuteur,
            'password' 
        );
        $tuteur->setPassword($hashedPassword);

        $this->entityManager->persist($tuteur);
        $this->entityManager->flush();

        $io->success('Tuteur user "tuteur@app.com" created successfully with password "password".');

        return Command::SUCCESS;
    }
}