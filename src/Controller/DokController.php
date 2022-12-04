<?php

namespace App\Controller;

use App\Entity\Product;
use App\Service\Searchers\ProductSearcher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DokController extends AbstractController
{
    #[Route('/dok', name: 'app_dok')]
    public function index(ProductSearcher $product_searcher): Response
    {
        $products = $product_searcher->getResults();

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
            )
        ]);
    }
}
