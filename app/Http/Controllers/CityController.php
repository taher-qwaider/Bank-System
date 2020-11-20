<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $cities = City::all();
        return response()->view('cms.Cities.index', ['cities'=>$cities]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $request->validate([
            'name'=>'required|string|min:3|max:35',
            'active'=>'in:on'
        ],[
            'name.required'=>'please, Enter a name',
            'name.min'=>'city name must be at least 3 charchters'
        ]);
        $city = new City();
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
        $request->validate([
            'name'=>'string|max:35|min:3|required',
            'active'=>'in:on'
        ], [
            'name.required'=>'please, Enter a name',
            'name.min'=>'city name must be at least 3 charchters'
        ]);
        $city = City::findOrFail($id);
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
    }
}
