<?php

namespace App\Service\Congressus;

use App\Service\Congressus\Responses\CongressusFetchMemberResponse;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

/**
 *
 */
class CongressusFetchMember
{
    private HttpClientInterface $client;
    private ContainerBagInterface $params;
    private const URL = 'https://api.congressus.nl/v30/members';

    /**
     * @param HttpClientInterface $client
     * @param ContainerBagInterface $params
     */
    public function __construct(HttpClientInterface $client, ContainerBagInterface $params)
    {
        $this->client = $client;
        $this->params = $params;
    }

    /**
     * @param int $page
     * @return CongressusFetchMemberResponse
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function getMembers(int $page): ?CongressusFetchMemberResponse
    {
        $params = [
            'page_size' => 100,
            'page' => $page
        ];

        $response = $this->client->request(
            'GET',
            self::URL . '?' . http_build_query($params),
            [
                'headers' => [
                    'Authorization: Bearer ' . $this->params->get('congressus.cleopatra.api_key')
                ]
            ]
        );

        if ($response->getStatusCode() !== 200) {
            return null;
        }
        return new CongressusFetchMemberResponse(json_decode($response->getContent(), true));
    }
}
