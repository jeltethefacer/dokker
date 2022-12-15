<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function index(UserRepository $user_repository): Response
    {
//            $user = $this->getUser();
//            $db_user = $user_repository->findOneByUUID($user?->getUserIdentifier());
//            $roles = $db_user?->getRoles();
//            var_dump($roles);
//    //        $roles[] = 'ROLE_PRODUCT_ADMIN';
//    //        $db_user->setRoles($roles);
//    //        $user_repository->save($db_user, true);

        return $this->render('homepage/index.html.twig', [
            'controller_name' => 'HomepageController',
        ]);
    }
}
