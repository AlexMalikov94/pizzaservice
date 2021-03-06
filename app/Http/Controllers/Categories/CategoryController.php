<?php

namespace App\Http\Controllers\Categories;

use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource; 
use App\Models\Category;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index() 
    {
    	return CategoryResource::collection(
            Category::with('children')->parents()->ordered()->get()
    	);
    }
}
