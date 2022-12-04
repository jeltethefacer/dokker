<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\CurrencyRepository;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use App\Service\Searchers\Conditions\ProductSearcher\Name;
use App\Service\Searchers\Conditions\ProductSearcher\Price;
use App\Service\Searchers\ProductSearcher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    private const ROLE = 'ROLE_PRODUCT_ADMIN';

    #[Route('/products', name: 'app_product')]
    public function index(UserRepository $repository): Response
    {
        if (!$this->isGranted(self::ROLE)) {
            return $this->redirectToRoute('app_homepage');
        }

        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }

    /**
     * @param Request $request
     * @param ProductSearcher $product_searcher
     * @return Response
     */
    #[Route('/products/search', name: 'app_product_search')]
    public function search(Request $request, ProductSearcher $product_searcher): Response
    {
        $this->denyAccessUnlessGranted(self::ROLE);

        if ($name = $request->query->get('_name')) {
            $product_searcher->addCondition(new Name($name));
        }

        if ($price = $request->query->filter('_price', FILTER_VALIDATE_FLOAT)) {
            $product_searcher->addCondition(new Price((float) $price));
        }

        $products = $product_searcher->getResults();

        return $this->json(
            array_map(
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
        );
    }

    #[Route('/product', name: 'app_create_product', methods: ["POST"])]
    public function createProduct(Request $request, ProductRepository $product_repository, CurrencyRepository $currency_repository): Response
    {
        $this->denyAccessUnlessGranted(self::ROLE);

        $product = new Product();
        $product->setName($request->request->get('_name'));
        $product->setDescription($request->request->get('_description'));
        $product->setPriceMinorAmount((int) ($request->request->filter('_price_euro', null, FILTER_VALIDATE_FLOAT) * 100));
        $product->setCurrency($currency_repository->find(1));
        // hash the password (based on the security.yaml config for the $user class)
        $product_repository->save($product, true);

        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }
}
