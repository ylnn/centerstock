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
use App\Http\Resources\OrderItem as OrderItemResource;

class OrderItemController extends Controller
{
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'integer|exists:orders,id',
        ]);

        $order = Order::owner($request->user())->where('id', $request->order_id)->firstOrFail();

        $orderItems = $order->items()->get();

        // dump($orderItems);

        if ($validator->fails()) {
            return response()->json()->setStatusCode(422);
        }

        return OrderItemResource::collection($orderItems);
    }


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

    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
                'order_id' => 'integer|exists:orders,id',
                'customer_id' => 'integer|exists:customers,id',
                'orderitem_id' => 'integer|exists:order_items,id',
            ]);

        $order = Order::owner($request->user())->where('id', $request->order_id)->firstOrFail();

        if ($validator->fails()) {
            return response()->json(['message'=>'validation error'])->setStatusCode(422);
        }

        $deleted = OrderItem::where('id', $request->orderitem_id)
                            ->where('customer_id', $request->customer_id)
                            ->where('order_id', $request->order_id)
                            ->delete();

        if (!$deleted) {
            return response()->json(['message'=>'deletion error'])->setStatusCode(422);
        }

        if (!$order->isOpen()) {
            return response()->json(['message' => 'order status is not open.'])->setStatusCode(422);
        }

        return response()->json(['message' => 'deleted'])->setStatusCode(200);
    }
}
