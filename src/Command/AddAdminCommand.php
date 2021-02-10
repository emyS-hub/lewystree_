<?php

namespace App\Command;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AddAdminCommand extends Command

{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:add-admin';

    private $em;
    private $encoder;

    public function __construct(EntityManagerInterface $em, UserPasswordEncoderInterface $encoder, UserRepository $userRepository)
    {
        $this->entityManager = $em;
        $this->encoder = $encoder;
        $this->userRepository = $userRepository;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Créer un admin en base de données')
            ->addArgument('username', InputArgument::REQUIRED, 'Identifiant admin')
            ->addArgument('plainPassword', InputArgument::REQUIRED, 'Mot de passe admin');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int

    {
        $io = new SymfonyStyle($input, $output);

        $username = $input->getArgument('username');
        $plainPassword = $input->getArgument('plainPassword');

        if ($username & $plainPassword) {

            $user = new User();

            $user->setUsername($username)
                ->setPassword($this->encoder->encodePassword($user, $plainPassword))
                ->setRoles(["ROLE_ADMIN"]);

            $this->em->persist($user);
            $this->em->flush();

            $io->note(sprintf('You passed an argument: %s as the username', $username));
            $io->note(sprintf('You passed an argument: %s as the password', $plainPassword));
        }

        $io->success('Un nouvel administrateur est inscrit en base de données');

        return Command::SUCCESS;
    }
}


  /*  {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');

        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }

        if ($input->getOption('option1')) {
            // ...
        }

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}*/