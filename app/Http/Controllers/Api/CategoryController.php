<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Traits\SaveImageTrait;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use ApiResponseTrait, SaveImageTrait;

    public function allCategories()
    {
        $categories = Category::translated()->get();
        if ((count($categories) == null)) {
            return $this->apiResponse($categories, 'There are not any Categories', 401);
        }
        return $this->apiResponse($categories, 'These Are All Categories', 200);
    }

    public function showCategory($category_id)
    {
        $category = Category::where('id', '=', $category_id)->with('advertisements')->first();
        if ($category) {
            return $this->apiResponse($category, 'This Is The Required Category', 200);
        }
        return $this->apiResponse($category, 'The Category Not Found', 401);
    }
}
