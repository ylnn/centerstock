<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Customer;
use App\Http\Resources\Customer as CustomerResource;
use Illuminate\Support\Facades\Validator;

class CustomerDetailController extends Controller
{
    /**
     * Customer Detail with ID
     *
     * @param Request $request
     * @param Customer $customer
     * @return void
     */
    public function index(Request $request, Customer $customer)
    {
        if (!$customer) {
            return response()->json('Not Found')->setStatusCode(404);
        }

        return new CustomerResource($customer);
    }
}
