<?php

namespace App\Command;

use App\Service\Congressus\ImportMembers;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name:'app:import-congressus-users', description: 'Imports the users from congressus')]
class ImportConressusUserCommand extends Command
{
    private ImportMembers $import_members;

    /**
     * @param ImportMembers $import_members
     */
    public function __construct(ImportMembers $import_members)
    {
        parent::__construct();
        $this->import_members = $import_members;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->import_members->importMembers($output);
        return Command::SUCCESS;
    }
}
