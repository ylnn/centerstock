<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\Http\Resources\Product as ProductResource;
use Illuminate\Support\Facades\Validator;

class ProductApiController extends Controller
{
    /**
     * Product Search with Name
     *
     * @param Request $request
     * @param [type] $productName
     * @return void
     */
    public function productSearch(Request $request, $productName)
    {
        if (strlen($productName) < 3) {
            return response()->json('Not Found')->setStatusCode(404);
        }
        $products = Product::where('name', 'like', '%'.$productName.'%')->take(10)->get();
        return ProductResource::collection($products);
    }

    /**
     * Product Detail with ID
     *
     * @param Request $request
     * @param Product $product
     * @return void
     */
    public function productDetail(Request $request, Product $product)
    {
        if(!$product){
            return response()->json('Not Found')->setStatusCode(404);
        }

        // return new Product($product);
    }
}
