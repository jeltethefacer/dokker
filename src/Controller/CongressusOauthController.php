<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CongressusOauthController extends AbstractController
{
    #[Route('/congressus/oauth', name: 'app_congressus_oauth')]
    public function index(): Response {
        return $this->redirect($this->generateUrl('app_homepage'));
    }
}
