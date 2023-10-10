<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request) {
        $text = $request->searchText ?? null;
        if(empty($text)) {
            return sendResponse([], 'prodcuts');
        }
        $data = Product::where('name' ,'like', '%'.$text.'%')->get();

        return sendResponse($data, 'prodcuts');
    }

    public function getHomeProducts(Request $request) {
        
        $data = Product::inRandomOrder(7)->get();

        return sendResponse($data, 'prodcuts');
    }

    public function getProductsByCategory(Request $request, $category_id) {
        
        $data = Product::when(true, function ($query) use ($category_id) {
            if($category_id < 1) return $query;
            return $query->where('category_id', $category_id);
        })->with('category')->get();

        return sendResponse($data, 'prodcuts');
    }
}
