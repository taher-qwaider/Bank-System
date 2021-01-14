<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CityController extends Controller
{
    // public function __construct()
    // {
    //     $this->authorizeResource(City::class, 'city');
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $this->authorize('viewAny', City::class);
        $cities = City::withCount('admins')->paginate(10);
        if($request->expectsJson()){
            return response()->json(['status'=>true, 'data'=>$cities], 200);
        }else{
            return response()->view('cms.Cities.index', ['cities'=>$cities]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $this->authorize('create', City::class);
        return response()->view('cms.Cities.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $city = new City();
        $this->authorize('create', $city);
        $request->validate([
            'name'=>'required|string|min:3|max:35',
            'active'=>'in:on'
        ],[
            'name.required'=>'please, Enter a name',
            'name.min'=>'city name must be at least 3 charchters'
        ]);
        $city->name=$request->get('name');
        $city->active= $request->has('active')? true:false;
        $isSaved = $city->save();
        if ($isSaved) {
            session()->flash('massege', 'City created successfuly');
            return redirect()->route('cities.create');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //

        $city = City::findOrFail($id);
        $this->authorize('update', $city);
        return response()->view('cms.Cities.edit', ['city'=>$city]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $city = City::findOrFail($id);
        $this->authorize('update', $city);
        $request->validate([
            'name'=>'string|max:35|min:3|required',
            'active'=>'in:on'
        ], [
            'name.required'=>'please, Enter a name',
            'name.min'=>'city name must be at least 3 charchters'
        ]);
        $city->name = $request->name;
        $city->active = $request->has('active');
        $isUpdated = $city->save();
        if($isUpdated){
            return redirect()->route('cities.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $this->authorize('create', City::findOrFail($id));
        $IsDeleted = City::destroy($id);
        if($IsDeleted){
            return response()->json(['title'=>'Deleted!', 'massege'=>'City Deleted Successfuly', 'icon'=>'success'],200);
        }else{
            return response()->json(['title'=>'Failed!', 'massege'=>'Failed to delete the City', 'icon'=>'error'],400);
        }
    }
}
