<?php

namespace App\Service\Congressus;

use App\Repository\CongressusUserInformationRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class CongressusUserAuthenticator extends AbstractAuthenticator
{
    public CongressusUserInformationRepository $congressus_user_information_repository;
    public CongressusOauthRequest $congressus_oauth_request;

    /**
     * @param CongressusUserInformationRepository $congressus_user_information_repository
     * @param CongressusOauthRequest $congressus_oauth_request
     */
    public function __construct(CongressusUserInformationRepository $congressus_user_information_repository, CongressusOauthRequest $congressus_oauth_request)
    {
        $this->congressus_user_information_repository = $congressus_user_information_repository;
        $this->congressus_oauth_request = $congressus_oauth_request;
    }

    /**
     * Called on every request to decide if this authenticator should be
     * used for the request. Returning `false` will cause this authenticator
     * to be skipped.
     */
    public function supports(Request $request): ?bool
    {
        if (str_contains($request->getUri(), '/congressus/oauth')) {
            return true;
        }
        return false;
    }

    /**
     * @param Request $request
     * @return SelfValidatingPassport
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function authenticate(Request $request): SelfValidatingPassport
    {
        $code = $request->query->get('code');
        if (!$code) {
            // The token header was empty, authentication fails with HTTP Status
            // Code 401 "Unauthorized"
            throw new CustomUserMessageAuthenticationException('No token provided');
        }
        $response = $this->congressus_oauth_request->doRequest($code);
        if (
            $response->getUserId()
            && ($congressus_user_information = $this->congressus_user_information_repository->findOneByCongressusUserId($response->getUserId()))
            && $congressus_user_information->getUser()
        ) {
            return new SelfValidatingPassport(
                new UserBadge($congressus_user_information->getUser()->getUuid()),
                [
                    new RememberMeBadge()
                ]
            );
        }
        throw new CustomUserMessageAuthenticationException('Authentication at congresssus failed.');
    }

    /**
     * @param Request $request
     * @param TokenInterface $token
     * @param string $firewallName
     * @return Response|null
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        // on success, let the request continue
        return null;
    }

    /**
     * @param Request $request
     * @param AuthenticationException $exception
     * @return Response|null
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $data = [
            // you may want to customize or obfuscate the message first
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData())

            // or to translate this message
            // $this->translator->trans($exception->getMessageKey(), $exception->getMessageData())
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }
}
