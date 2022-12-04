<?php

namespace App\Service\Congressus;

use App\Entity\Association;
use App\Entity\CongressusUserInformation;
use App\Entity\User;
use App\Repository\AssociationRepository;
use App\Repository\CongressusUserInformationRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\NonUniqueResultException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class ImportMembers
{
    private CongressusFetchMember $congressus_fetch_member;
    private CongressusUserInformationRepository $congressus_user_information_repository;
    private UserRepository $user_repository;
    private UserPasswordHasherInterface $password_hasher;
    private AssociationRepository $association_repository;

    public function __construct(
        CongressusFetchMember $congressus_fetch_member,
        CongressusUserInformationRepository $congressus_user_information_repository,
        UserRepository $user_repository,
        UserPasswordHasherInterface $password_hasher,
        AssociationRepository $association_repository
    ) {
        $this->congressus_fetch_member = $congressus_fetch_member;
        $this->congressus_user_information_repository = $congressus_user_information_repository;
        $this->password_hasher = $password_hasher;
        $this->user_repository = $user_repository;
        $this->association_repository = $association_repository;
    }

    /**
     * @param OutputInterface|null $output
     * @return bool
     * @throws ClientExceptionInterface
     * @throws ContainerExceptionInterface
     * @throws NonUniqueResultException
     * @throws NotFoundExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function importMembers(?OutputInterface $output = null): bool
    {
        ini_set('max_execution_time', '300'); //300 seconds = 5 minutes
        $page = 1;
        do {
            $members_response = $this->congressus_fetch_member->getMembers($page);
            if (!$members_response) {
                break;
            }

            foreach ($members_response->getMembers() as $response) {
                if (!$response->getId()) {
                    continue;
                }

                $congressus_user_information = $this->congressus_user_information_repository->findOneByCongressusUserId($response->getId());
                if (!$congressus_user_information) {
                    $congressus_user_information = new CongressusUserInformation();
                    $congressus_user_information->setCongressusUserId($response->getId());
                }
                $congressus_user_information->setEmail($response->getEmail());
                $congressus_user_information->setIban($response->getIBAN());
                $congressus_user_information->setUsername($response->getUsername());
                $congressus_user_information->setFirstName($response->getFirstName());
                $congressus_user_information->setPrimaryLastNamePrefix($response->getPrimaryLastNamePrefix());
                $congressus_user_information->setPrimaryLastName($response->getPrimaryLastName());
                $this->congressus_user_information_repository->save($congressus_user_information, true);

                if (!$congressus_user_information->getUser()) {
                    $user = new User();
                    $user->setAssociation($this->association_repository->find(Association::PRIMARY_ASSOCIATION));
                    $user->setUuid('congressus_' . $response->getId());

                    // hash the password (based on the security.yaml config for the $user class)
                    $hashed_password = $this->password_hasher->hashPassword(
                        $user,
                        $this->generateRandomString()
                    );

                    $user->setPassword($hashed_password);
                    $user->setCongressusUserInformation($congressus_user_information);
                    $this->user_repository->save($user, true);
                }
                $output?->writeln('Imported ' . $congressus_user_information->getFirstName() . ' (' . $congressus_user_information->getCongressusUserId() . ')');
            }
            $page ++;
        }  while ($members_response->hasNext());
        return true;
    }

    /**
     * @param $length
     * @return string
     */
    private function generateRandomString($length = 36) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
