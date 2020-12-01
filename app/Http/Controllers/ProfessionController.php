<?php

namespace App\Http\Controllers;

use App\Models\Profession;
use Illuminate\Http\Request;

class ProfessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //paginate
        $Professions=Profession::paginate(10);
        return response()->view('cms.Profession.index', ['Professions'=>$Professions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return response()->view('cms.Profession.create');
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
            'name'=>'required|min:3|max:35|string',
            'active'=>'in:on'
        ], [
            'name.required'=>'please, Enter Profession',
            'name.min'=>'name must be at least 3 chrachters'
        ]);
        $Profession =new Profession();
        $Profession->name=$request->name;

        if ($request->active) {
            $Profession->active=true;
        }
        else{
            $Profession->active=false;
        }
        $isSaved = $Profession->save();
        if($isSaved){
            session()->flash('SaveMassege', 'Profession created successfuly');
            return redirect()->route('Profession.create');
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
        $Profession=Profession::findOrFail($id);
        return response()->view('cms.Profession.edit', ['profession'=>$Profession]);
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
            'name'=>'required|min:3|max:35|string',
            'active'=>'in:on'
        ], [
            'name.required'=>'please, Enter Profession',
            'name.min'=>'name must be at least 3 chrachters'
        ]);
        $Profession=Profession::findOrFail($id);
        $Profession->name=$request->name;

        if ($request->active) {
            $Profession->active=true;
        }
        else{
            $Profession->active=false;
        }
        $isSaved = $Profession->save();
        if($isSaved){
            session()->flash('updataMassege', 'Profession Updataed successfuly');
            return redirect()->route('Profession.index');
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
        $isDeleted = Profession::destroy($id);
        if($isDeleted){
            return response()->json(['title'=>'Deleted!', 'massege'=>'City Deleted Successfuly', 'icon'=>'success'], 200);
        }else{
            return response()->json(['title'=>'Fail!', 'massege'=>'Fail to Delete the City', 'icon'=>'error'], 400);
        }
    }
}
