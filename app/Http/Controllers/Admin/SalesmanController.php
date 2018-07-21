<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Salesman;


class SalesmanController extends Controller
{
    const baseRoute = 'admin.salesman';
    const indexRoute = 'admin.salesman.index';
    const model = 'App\Salesman';
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
        return view(self::baseRoute . '.create', ['baseRoute' => self::baseRoute]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'email|required',
            'password' => 'required|string|min:8|max:20',
            'name' => 'string|required|unique:salesmen,name',
            'status' => 'boolean|required',
            'area_id' => 'integer|required|exists:areas,id',
            'phone' => 'string|nullable',
            'address' => 'string|nullable',
            'desc' => 'string|nullable',
        ]);

        Salesman::create($request->only('email', 'password', 'name', 'status', 'area_id', 'phone', 'address', 'desc'));

        showMessage(trans('adminLang.saved'), 'success');

        // return !empty(request('previous')) ? redirect(request('previous')) : redirect()->route(self::indexRoute);

        return redirect()->route(self::indexRoute);
    }
    
    public function show(Salesman $salesman)
    {
        return view('admin.salesman.show', ['record' => $salesman, 'baseRoute' => self::baseRoute]);
    }

    public function edit(Salesman $salesman)
    {
        return view('admin.salesman.edit', ['record' => $salesman, 'baseRoute' => self::baseRoute]);
    }

    public function update(Request $request, Salesman $salesman)
    {
        $this->validate($request, [
            'name' => 'string|required',
            'phone' => 'string|nullable',
            'email' => 'string|nullable',
        ]);

        $salesman->update($request->only('name', 'phone', 'email'));

        showMessage(trans('adminLang.saved'), 'success');

        // return !empty(request('previous')) ? redirect(request('previous')) : redirect()->route(self::indexRoute);

        return redirect()->route(self::indexRoute);
    }

    public function delete(Request $request, Salesman $salesman)
    {
       if ($salesman->delete()){
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