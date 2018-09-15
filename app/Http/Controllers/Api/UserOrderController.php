<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Customer;
use App\Http\Resources\Customer as CustomerResource;
use Illuminate\Support\Facades\Validator;
use App\Order;

class UserOrderController extends Controller
{
    /**
     * Customer Detail with ID
     *
     * @param Request $request
     * @param Customer $customer
     * @return void
     */
    public function create(Request $request, Customer $customer)
    {
        if (!$customer) {
            return response()->json('Not Found')->setStatusCode(404);
        }

        $order = new Order(['status' => 'OPEN']);

        return $customer->addOrder($order, $request->user());
    }

    /**
     * User get own orders
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'nullable|in:'.implode(',', Order::STATUS),
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'STATUS ERROR'])->setStatusCode(422);
        }
        
        return $request->user()->orders()->status($request->status)->get();
    }
}
