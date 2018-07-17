<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Area;


class AreaController extends Controller
{
    const baseRoute = 'admin.area';
    const indexRoute = 'admin.area.index';
    const model = 'App\Area';
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
            'name' => 'string|required|unique:areas,name',
            'phone' => 'string|nullable',
            'email' => 'string|nullable',
        ]);

        Area::create($request->only('name', 'phone', 'email'));

        showMessage(trans('adminLang.saved'), 'success');

        // return !empty(request('previous')) ? redirect(request('previous')) : redirect()->route(self::indexRoute);

        return redirect()->route(self::indexRoute)
    }
    
    public function show(Area $area)
    {
        return view('admin.area.show', ['record' => $area, 'baseRoute' => self::baseRoute]);
    }

    public function edit(Area $area)
    {
        return view('admin.area.edit', ['record' => $area, 'baseRoute' => self::baseRoute]);
    }

    public function update(Request $request, Area $area)
    {
        $this->validate($request, [
            'name' => 'string|required',
            'phone' => 'string|nullable',
            'email' => 'string|nullable',
        ]);

        $area->update($request->only('name', 'phone', 'email'));

        showMessage(trans('adminLang.saved'), 'success');

        // return !empty(request('previous')) ? redirect(request('previous')) : redirect()->route(self::indexRoute);

        return redirect()->route(self::indexRoute)
    }

    public function delete(Request $request, Area $area)
    {
       if ($area->delete()){
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
