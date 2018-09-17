<?php

namespace App\Http\Controllers\Api;

use App\Order;
use App\Stock;
use App\Customer;
use App\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Customer as CustomerResource;

class OrderItemController extends Controller
{
    /*     public function index(Request $request)
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
        } */


    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
                'order_id' => 'integer|exists:orders,id',
                'stock_id' => 'integer|exists:stocks,id',
                'quantity' => 'integer|min:1'
            ]);

        if ($validator->fails()) {
            return response()->json()->setStatusCode(422);
        }

        $order = Order::findOrFail($request->order_id);

        $stock = Stock::findOrFail($request->stock_id);

        $orderItem = OrderItem::make([
            'customer_id' => $request->customer_id,
            'stock_id' => $request->stock_id,
            'quantity' => $request->quantity,
            'user_id' => $request->user()->id,
        ]);

        if (!$stock->isAvailableFor($orderItem->quantity)) {
            return response()->json(['message' => 'stock is not enough.'])->setStatusCode(422);
        }

        if (!$order->isOpen()) {
            return response()->json(['message' => 'order status is not open.'])->setStatusCode(422);
        }

        return $order->items()->save($orderItem);
    }
}
