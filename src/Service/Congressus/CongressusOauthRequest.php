<?php


namespace App\Service\Congressus;

use App\Service\Congressus\Responses\CongressusOauthResponse;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Service to do oauth requests to congressus
 */
class CongressusOauthRequest
{
    private HttpClientInterface $client;
    private ContainerBagInterface $params;
    private const URL = 'https://www.cleopatra-groningen.nl/oauth/token';

    /**
     * CongressusOauthRequest constructor.
     * @param HttpClientInterface $client
     * @param ContainerBagInterface $params
     */
    public function __construct(HttpClientInterface $client, ContainerBagInterface $params)
    {
        $this->client = $client;
        $this->params = $params;
    }

    /**
     * @param string $code
     * @return CongressusOauthResponse
     * @throws ClientExceptionInterface
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function doRequest(string $code): CongressusOauthResponse
    {
        $response = $this->client->request(
            'POST',
            self::URL,
            [
                'body' => 'grant_type=authorization_code&code=' .  $code,
                'auth_basic' => [$this->params->get('congressus.cleopatra.client_id'), $this->params->get('congressus.cleopatra.client_secret')],
                'headers' => [
                    'Content-Type: application/x-www-form-urlencoded'
                ]
            ]
        );
//
//        $curl = curl_init('ext-curl');
//        curl_setopt($curl, CURLOPT_URL, self::URL);
//        curl_setopt($curl, CURLOPT_POST, true);
//        curl_setopt($curl, CURLOPT_POSTFIELDS, 'grant_type=authorization_code&code=' .  $this->code);
//        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
//        curl_setopt($curl, CURLOPT_USERPWD, env('CONGRESSUS_CLIENT_ID') . ":" . env('CONGRESSUS_CLIENT_SECRET'));
//        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        return new CongressusOauthResponse(json_decode($response->getContent(), true));
    }
}
