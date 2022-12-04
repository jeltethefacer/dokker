<?php

namespace App\Service\Congressus\Responses;

/**
 * Congressus member data.
 */
class CongressusFetchMemberMember
{
    private array $data = [];

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->data['id'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->data['username'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->data['first_name'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getPrimaryLastNamePrefix(): ?string
    {
        return $this->data['primary_last_name_prefix'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getPrimaryLastName(): ?string
    {
        return $this->data['primary_last_name'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->data['email'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getIBAN(): ?string
    {
        return $this->data['bank_account']['iban'] ?? null;
    }
}
