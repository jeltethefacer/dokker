<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\Searchers\ProductSearcher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DokController extends AbstractController
{
    #[Route('/dok', name: 'app_dok')]
    public function index(ProductSearcher $product_searcher, UserRepository $user_repository): Response
    {
        $products = $product_searcher->getResults();
        $users = $user_repository->findAll();

        return $this->render('dok/index.html.twig', [
            'controller_name' => 'DokController',
            'products' => array_map(
                function (Product $product) {
                    return [
                        'id' => $product->getId(),
                        'name' => $product->getName(),
                        'price_minor_amount' => $product->getPriceMinorAmount(),
                        'currency_id' => $product->getCurrency()->getId()
                    ];
                },
                $products
            ),
            'users' => array_map(
                function (User $user) {
                    return [
                        'id' => $user->getId(),
                        'name' => $user->getCongressusUserInformation()?->getFirstName() .
                            ' ' .
                            ($user->getCongressusUserInformation()?->getPrimaryLastNamePrefix() ? ($user->getCongressusUserInformation()?->getPrimaryLastNamePrefix() . ' ') : '') .
                            $user->getCongressusUserInformation()?->getPrimaryLastName(),
                        'image_url' => $user->getCongressusUserInformation()?->getIban(),
                    ];
                },
                $users
            )
        ]);
    }
}
