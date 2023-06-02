<?php

namespace App\Services;

use App\Http\Requests\ProductRequest;
use App\Http\Requests\SerachProductRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Repositories\ProductRepository;
use Exception;
use PhpParser\Node\Expr\FuncCall;

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

    public function deleteProduct(string $id)
    {
        $product = $this->productRepository->findById($id);
        if(!$product) throw new Exception("Nie znaleziono zasobu!");

        $this->productRepository->delete($product);
    }

    public function serachProduct(SerachProductRequest $request)
    {
        $product = null;

        if($request->filled('nazwa') && $request['kategoria'] > 0)
        {
            $product = $this->productRepository->findByNameAndCategory($request['nazwa'], $request['kategoria']);
        }
        else if($request->filled('nazwa') && $request['kategoria'] == 0)
        {
            $product = $this->productRepository->findByName($request['nazwa']);
        }   
        else if(!$request->filled('nazwa') && $request['kategoria'] > 0)
        {
            $product = $this->productRepository->findByCategory($request['kategoria']);
        }
        else if(!$request->filled('nazwa') && $request['kategoria'] == 0)
        {
            $product = $this->productRepository->getAll();
        }
    
        if(!$product) throw new Exception("Nie znaleziono zasobów!");
    
        return new ProductCollection($product);
    }

    public function showProduct(string $id)
    {
        $product = $this->productRepository->findById($id);
        if(!$product) throw new Exception("Nie znaleziono zasobu!");

        return new ProductResource($product);
    }   
    
}