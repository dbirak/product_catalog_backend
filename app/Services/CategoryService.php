<?php

namespace App\Services;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Repositories\CategoryRepository;
use Exception;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class CategoryService {

    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAllCategories()
    {
        return CategoryResource::collection($this->categoryRepository->getAll());
    }

    public function createCategory(CategoryRequest $request)
    {
        $category = $this->categoryRepository->create($request);

        return new CategoryResource($category);
    }

    public function updateCategory(CategoryRequest $request, string $id)
    {
        $category = $this->categoryRepository->findById($id);
        if(!$category) throw new Exception("Nie znaleziono zasobu!");

        $updatedCategory = $this->categoryRepository->update($request, $category);

        return new CategoryResource($updatedCategory);
    }

    public function deleteCategory(string $id)
    {
        $category = $this->categoryRepository->findById($id);
        if(!$category) throw new Exception("Nie znaleziono zasobu!");

        $this->categoryRepository->delete($category);
    }
    
}