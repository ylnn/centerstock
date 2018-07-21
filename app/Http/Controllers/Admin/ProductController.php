<?php

namespace App\Http\Controllers\Admin;

use App\Area;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class ProductController extends Controller
{
    const baseRoute = 'admin.product';
    const indexRoute = 'admin.product.index';
    const model = 'App\Product';
    const pagination = 15;

    public function index()
    {

        $q = request('q');
        $sort = request('sort') ?? '';
        $direction = request('direction') ?? '';

        # start query
        $query = (self::model)::whereNotNull('id');

        # get set orderBy method
        $query = $this->getOrderByField($query, $sort, $direction);

        # if query parameter exists
        $query = $q ? $query->where('name', 'like', '%' . $q . '%') : $query;

        $records = $query->paginate(self::pagination)->appends(request()->query());;

        $baseRoute = self::baseRoute;
        
        return view(self::baseRoute.".index", compact('records', 'q', 'p', 'sort', 'direction', 'baseRoute'));

    }

    public function create()
    {
        return view(self::baseRoute . '.create', ['baseRoute' => self::baseRoute, 'areas' => Area::orderBy('name', 'ASC')->get()]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'string|required|unique:products,name',
            'base_price' => "required|regex:/^\d*(\.\d{1,2})?$/",
        ]);

        Product::create($request->only('name', 'base_price'));

        showMessage(trans('adminLang.saved'), 'success');

        // return !empty(request('previous')) ? redirect(request('previous')) : redirect()->route(self::indexRoute);
        return redirect()->route(self::indexRoute);
    }
    
    public function show(Product $product)
    {
        return view('admin.product.show', ['record' => $product, 'baseRoute' => self::baseRoute]);
    }

    public function edit(Product $product)
    {
        return view('admin.product.edit', [
            'record' => $product, 
            'baseRoute' => self::baseRoute, 
            'areas' => Area::orderBy('name', 'ASC')->get()
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $this->validate($request, [
            'name' => 'string|required',
            'base_price' => "required|regex:/^\d*(\.\d{1,2})?$/",
        ]);

        $product->update($request->only('name', 'base_price'));

        showMessage(trans('adminLang.saved'), 'success');

        // return !empty(request('previous')) ? redirect(request('previous')) : redirect()->route(self::indexRoute);
        return redirect()->route(self::indexRoute);
    }

    public function delete(Request $request, Product $product)
    {
       if ($product->delete()){
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
