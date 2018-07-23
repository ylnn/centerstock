<?php

namespace App\Http\Controllers\Admin;

use App\Area;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;


class SalesmanController extends Controller
{
    const baseRoute = 'admin.salesman';
    const indexRoute = 'admin.salesman.index';
    const model = 'App\User';
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
            'password' => 'required|min:8|max:20',
            'name' => 'string|required|unique:users,name',
            'status' => 'boolean|required',
            'area_id' => 'integer|required|exists:areas,id',
            'phone' => 'string|nullable',
            'address' => 'string|nullable',
            'desc' => 'string|nullable',
        ]);



        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => $request->status,
            'area_id' => $request->area_id,
            'phone' => $request->phone,
            'address' => $request->address,
            'desc' => $request->desc,
        ]);

        showMessage(trans('adminLang.saved'), 'success');

        // return !empty(request('previous')) ? redirect(request('previous')) : redirect()->route(self::indexRoute);

        return redirect()->route(self::indexRoute);
    }
    
    public function show(User $user)
    {
        return view('admin.salesman.show', ['record' => $user, 'baseRoute' => self::baseRoute]);
    }

    public function edit(User $user)
    {
        $areas = Area::orderBy('name', 'ASC')->get();
        return view('admin.salesman.edit', ['record' => $user, 'baseRoute' => self::baseRoute, 'areas' => $areas]);
    }

    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'string|required',
            'email' => 'email|required',
            'status' => 'boolean|required',
            'area_id' => 'integer|required|exists:areas,id',
            'phone' => 'string|nullable',
            'address' => 'string|nullable',
            'desc' => 'string|nullable',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => $request->status,
            'area_id' => $request->area_id,
            'phone' => $request->phone,
            'address' => $request->address,
            'desc' => $request->desc,
        ]);

        showMessage(trans('adminLang.saved'), 'success');

        // return !empty(request('previous')) ? redirect(request('previous')) : redirect()->route(self::indexRoute);

        return redirect()->route(self::indexRoute);
    }

    public function delete(Request $request, User $user)
    {
       if ($user->delete()){
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
