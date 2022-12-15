<?php

namespace App\Entity;

use App\Repository\CongressusUserInformationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CongressusUserInformationRepository::class)]
#[ORM\Table(name: '`congressus_user_informations`')]
class CongressusUserInformation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $congressus_user_id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $username = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $first_name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $primary_last_name_prefix = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $primary_last_name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $iban = null;

    #[ORM\OneToOne(mappedBy: 'congressus_user_information', targetEntity: User::class)]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCongressusUserId(): ?int
    {
        return $this->congressus_user_id;
    }

    public function setCongressusUserId(int $congressus_user_id): self
    {
        $this->congressus_user_id = $congressus_user_id;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(?string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getPrimaryLastNamePrefix(): ?string
    {
        return $this->primary_last_name_prefix;
    }

    public function setPrimaryLastNamePrefix(?string $primary_last_name_prefix): self
    {
        $this->primary_last_name_prefix = $primary_last_name_prefix;

        return $this;
    }

    public function getPrimaryLastName(): ?string
    {
        return $this->primary_last_name;
    }

    public function setPrimaryLastName(?string $primary_last_name): self
    {
        $this->primary_last_name = $primary_last_name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getIban(): ?string
    {
        return $this->iban;
    }

    public function setIban(?string $iban): self
    {
        $this->iban = $iban;

        return $this;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function setUser(User $user): self
    {
        $user->setCongressusUserInformation($this);
        $this->user = $user;
        return $this;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function removeUser(User $user): self
    {
        $user->setCongressusUserInformation(null);
        $this->user = null;
        return $this;
    }
}
