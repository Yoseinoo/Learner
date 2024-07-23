<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoriesController extends Controller {

    public function getAll(): JsonResponse {
        $cats = Category::all();

        return response()->json($cats);
    }
}