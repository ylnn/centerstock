<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Customer;
use App\Http\Resources\Customer as CustomerResource;
use Illuminate\Support\Facades\Validator;
use App\Order;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'nullable|in:'.implode(',', Order::STATUS),
            'customer_id' => 'integer|exists:customers,id'
        ]);

        if ($validator->fails()) {
            return response()->json()->setStatusCode(422);
        }

        $customer = Customer::find($request->customer_id);

        return Order::owner($request->user())->customer($customer)->get();
    }


    public function create(Request $request, Customer $customer)
    {
        if (!$customer) {
            return response()->json('Not Found')->setStatusCode(404);
        }

        $order = new Order(['status' => 'OPEN']);

        return $customer->addOrder($order, $request->user());
    }
}
