<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    #[Route('/register', name: 'app_register_get', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('register/index.html.twig', [
            'controller_name' => 'RegisterController',
        ]);
    }

    #[Route('/register', name: 'app_register_post', methods: ['POST'])]
    public function store(Request $request, UserRepository $user_repository, UserPasswordHasherInterface $password_hasher): Response
    {
        $user = new User();
        $user->setUuid($request->request->get('_uuid'));

        // hash the password (based on the security.yaml config for the $user class)
        $hashed_password = $password_hasher->hashPassword(
            $user,
            $request->request->get('_password')
        );

        $user->setPassword($hashed_password);
        $user_repository->save($user, true);
        return $this->redirect($this->generateUrl('app_login'));
    }
}
