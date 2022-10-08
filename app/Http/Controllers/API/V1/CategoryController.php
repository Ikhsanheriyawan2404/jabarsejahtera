<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();
        return new CategoryResource(true, 'List Categories', $categories);
    }

    public function show(Category $category)
    {
        return new CategoryResource(true, 'Details Category', Category::find($category));
    }

}
