<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Stock;
use App\Product;

class StockController extends Controller
{
    const baseRoute = 'admin.stock';
    const indexRoute = 'admin.stock.index';
    const model = 'App\Stock';
    const pagination = 15;

    public function index(Product $product)
    {
        $q = request('q');
        $sort = request('sort') ?? '';
        $direction = request('direction') ?? '';

        # start query
        $query = (self::model)::whereNotNull('id');

        # get set orderBy method
        $query = $this->getOrderByField($query, $sort, $direction);

        $query = $query->where('product_id', $product->id);

        # if query parameter exists
        // $query = $q ? $query->where('name', 'like', '%' . $q . '%') : $query;

        // $query = $query->whereHas('product', function ($query) use ($q){
        //     $query->where('name', 'like', '%'.$q.'%');
        // });

        // $query = $query->with(['product' => function($query) use ($q){
        //     $query->where('name', 'like', '%'. $q . '%');
        // }]);

        $records = $query->paginate(self::pagination)->appends(request()->query());

        $baseRoute = self::baseRoute;
        
        return view(self::baseRoute.".index", compact('product', 'records', 'q', 'p', 'sort', 'direction', 'baseRoute'));
    }

    public function create(Product $product)
    {
        return view(self::baseRoute . '.create', [
            'product' => $product,
            'baseRoute' => self::baseRoute
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'serial' => 'integer|required|unique:stocks,serial',
            'product_id' => 'integer',
            'quantity' => 'integer|required',
            'purchase_price' => "required",
            'sale_price' => "required",
            'user_id' => 'integer|required|exists:users,id',
            'expiration_at' => 'date|nullable',
        ]);

        $stock = new Stock();
        $stock->serial = $request->serial;
        $stock->product_id = $request->product_id;
        $stock->quantity = $request->quantity;
        $stock->purchase_price = $request->purchase_price * 100;
        $stock->sale_price = $request->sale_price * 100;
        $stock->user_id = $request->user_id;
        $stock->expiration_at = $request->expiration_at;
        $stock->save();

        // Stock::create($request->only('name', 'phone', 'email'));

        showMessage(trans('adminLang.saved'), 'success');

        // return !empty(request('previous')) ? redirect(request('previous')) : redirect()->route(self::indexRoute);

        return redirect()->route(self::indexRoute, ['product' => $request->product_id]);
    }
    
    public function show(Product $product, Stock $stock)
    {
        return view('admin.stock.show', ['record' => $stock, 'product' => $product, 'baseRoute' => self::baseRoute]);
    }

    public function edit(Product $product, Stock $stock)
    {
        return view('admin.stock.edit', ['record' => $stock, 'product' => $product, 'baseRoute' => self::baseRoute]);
    }

    public function update(Request $request, Stock $stock)
    {
        $this->validate($request, [
            'quantity' => 'integer|required',
            'purchase_price' => "required|numeric",
            'sale_price' => "required|numeric",
            'user_id' => 'integer|required|exists:users,id',
            'expiration_at' => 'date|nullable',
        ]);

        $stock->quantity = $request->quantity;
        $stock->purchase_price = $request->purchase_price * 100;
        $stock->sale_price = $request->sale_price * 100;
        $stock->user_id = $request->user_id;
        $stock->expiration_at = $request->expiration_at;
        $stock->save();

        showMessage(trans('adminLang.saved'), 'success');

        // return !empty(request('previous')) ? redirect(request('previous')) : redirect()->route(self::indexRoute);

        return redirect()->route(self::indexRoute, ['product' => $stock->product_id]);
    }

    public function delete(Request $request, Product $product, Stock $stock)
    {
        if ($stock->delete()) {
            showMessage(trans('adminLang.deleted'), 'success');
        } else {
            showMessage(trans('adminLang.cantdeleted'), 'success');
        }
        return back();
    }

    protected function getOrderByField($query, string $sort = "created_at", $direction = "ASC")
    {
        $sort = $sort ? $sort : "created_at";
        return $query->orderBy($sort, $direction);
    }
}
