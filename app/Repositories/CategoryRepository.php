<?php

namespace App\Repositories;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;

class CategoryRepository {

    protected $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function getAll()
    {
        return $this->category::all();
    }

    public function create(CategoryRequest $request)
    {
        $category = new Category(); 
        $category->name = $request['nazwa'];
        $category->save();

        return $category;
    }

    public function findById(string $id)
    {
        return $this->category::where('id', $id)->first();
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $category->name = $request['nazwa'];
        $category->save();

        return $category;
    }

    public function delete(Category $category)
    {
        $category->delete();
    }

}