<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Customer;
use App\Http\Resources\Customer as CustomerResource;
use Illuminate\Support\Facades\Validator;

class ProductApiController extends Controller
{
    /**
     * Customer Search with Name
     *
     * @param Request $request
     * @param [type] $customerName
     * @return void
     */
    public function customerSearch(Request $request, $customerName)
    {
        if (strlen($customerName) < 3) {
            return response()->json('Not Found')->setStatusCode(404);
        }
        $customers = Customer::where('name', 'like', '%'.$customerName.'%')->take(10)->get();
        return CustomerResource::collection($customers);
    }

    /**
     * Customer Detail with ID
     *
     * @param Request $request
     * @param Customer $customer
     * @return void
     */
    public function customerDetail(Request $request, Customer $customer)
    {
        if(!$customer){
            return response()->json('Not Found')->setStatusCode(404);
        }

        return new CustomerResource($customer);
    }
}
