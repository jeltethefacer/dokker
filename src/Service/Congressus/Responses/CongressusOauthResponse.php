<?php

namespace App\Service\Congressus\Responses;

/**
 * Class OauthResponse
 * @package App\Services\Congressus\Responses
 */
class CongressusOauthResponse
{
    private array $result;

    /**
     * OauthResponse constructor.
     * @param array $result
     */
    public function __construct(array $result)
    {
        $this->result = $result;
    }

    /**
     * @return string|null
     */
    public function getUserId(): ?string
    {
        return $this->result['user_id'] ?? null;
    }

    public function getAccessToken(): ?string
    {
        return array_key_exists('access_token',  $this->result) ? $this->result['access_token'] : null;
    }

    public function getReturn(): ?array
    {
        return array_key_exists('return', $this->result) ? $this->result['return'] : null;
    }

    public function getError(): ?string
    {
        return array_key_exists('error', $this->result) ? $this->result['error'] : null;
    }

    /**
     * @return array
     */
    public function getResult(): array
    {
        return $this->result;
    }
}
