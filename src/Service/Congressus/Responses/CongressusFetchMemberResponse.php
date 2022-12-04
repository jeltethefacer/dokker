<?php

namespace App\Service\Congressus\Responses;

/**
 * Congerssus fetch member response
 */
class CongressusFetchMemberResponse
{
    private array $data;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return CongressusFetchMemberMember[]
     */
    public function getMembers(): array
    {
        $members = $this->data['data'] ?? [];
        $return_member = [];
        foreach ($members as $member) {
            $return_member[] = new CongressusFetchMemberMember($member);
        }
        return $return_member;
    }

    /**
     * @return bool
     */
    public function hasNext(): bool
    {
        return $this->data['has_next'] ?? false;
    }
}
