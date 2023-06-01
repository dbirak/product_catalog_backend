<?php

namespace App\Services;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Repositories\ProductRepository;

class ProductService {

    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function createProduct(ProductRequest $request)
    {
        $product = $this->productRepository->create($request);

        return new ProductResource($product);
    }

    public function getAllProducts()
    {
        return new ProductCollection($this->productRepository->getAll());
    }
    
}