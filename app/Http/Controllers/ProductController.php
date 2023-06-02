<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Requests\SerachProductRequest;
use App\Services\ProductService;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $res = $this->productService->getAllProducts();
        return response($res, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $res = $this->productService->createProduct($request);
        return response($res, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try
        {
            $res = $this->productService->showProduct($id);
            return response($res, 200);
        }
        catch(Exception $e)
        {
            if($e instanceof Exception)
                    return response(['message' => $e->getMessage()], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try
        {
            $this->productService->deleteProduct($id);
            return response([], 204);
        }
        catch(Exception $e)
        {
            if($e instanceof QueryException)
                    return response(['message' => $e->getMessage()], 409);
            else
                    return response(['message' => $e->getMessage()], 404);
        }
    }

    public function serach(SerachProductRequest $request)
    {
        try
        {
            $res = $this->productService->serachProduct($request);
            return response($res, 200);
        }
        catch(Exception $e)
        {
            return response(['message' => $e->getMessage()], 404);
        }
    }
}
