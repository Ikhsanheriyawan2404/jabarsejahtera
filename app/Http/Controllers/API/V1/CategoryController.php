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
        return new CategoryResource(true, 'Details Category', $category);
    }

    public function store()
    {
        $this->validate(request(), ['name' => 'required']);
        $category = Category::create(['name' => request('name')]);
        return new CategoryResource(true, 'Berhasil menambahkan kategori', $category);
    }

    public function update(Category $category)
    {
        $this->validate(request(), ['name' => 'required']);
        $category->update(['name' => request('name')]);
        return new CategoryResource(true, 'Berhasil mengedit kategori', $category);
    }

}
