<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Salesman;
use App\Area;


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
        $area_id = request('area_id') ?? '';

        # start query
        $query = (self::model)::whereNotNull('id');

        # get set orderBy method
        $query = $this->getOrderByField($query, $sort, $direction);

        # if query parameter exists
        $query = $q ? $query->where('name', 'like', '%' . $q . '%') : $query;

        if($area_id){
            $query = $query->where('area_id', $area_id);
        }

        $records = $query->paginate(self::pagination)->appends(request()->query());;

        $baseRoute = self::baseRoute;

        $areas = Area::orderBy('name', 'ASC')->get();
        
        return view(self::baseRoute.".index", compact('records', 'q', 'p', 'sort', 'direction', 'baseRoute', 'areas', 'area_id'));

    }

    public function create()
    {
        $areas = Area::orderBy('name', 'ASC')->get();
        return view(self::baseRoute . '.create', ['baseRoute' => self::baseRoute, 'areas' => $areas]);
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
        $areas = Area::orderBy('name', 'ASC')->get();
        return view('admin.salesman.edit', ['record' => $salesman, 'baseRoute' => self::baseRoute, 'areas' => $areas]);
    }

    public function update(Request $request, Salesman $salesman)
    {
        $this->validate($request, [
            'email' => 'email|required',
            'name' => 'string|required|unique:salesmen,name',
            'status' => 'boolean|required',
            'area_id' => 'integer|required|exists:areas,id',
            'phone' => 'string|nullable',
            'address' => 'string|nullable',
            'desc' => 'string|nullable',
        ]);

        $salesman->update($request->only('email', 'name', 'status', 'area_id', 'phone', 'address', 'desc'));

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
