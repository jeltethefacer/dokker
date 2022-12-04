<?php

namespace App\Service\Searchers;

use App\Entity\Product;
use App\Repository\ProductRepository;

class ProductSearcher extends Searcher
{
    private ProductRepository $product_repository;

    /**
     * @param ProductRepository $product_repository
     */
    public function __construct(ProductRepository $product_repository)
    {
        $this->product_repository = $product_repository;
    }

    /**
     * @return Product[]
     */
    public function getResults(): array
    {
        $query_builder =  $this->product_repository->getQueryBuilder();
        $query_builder = $this->addConditionsToQueryBuilder($query_builder);
        $query_builder->setMaxResults(100);
        return $query_builder->getQuery()->getResult();
    }
}
