<?php

namespace App\Http\Controllers;

use App\Models\IncomeType;
use Illuminate\Http\Request;

class IncomeTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $income_types = IncomeType::paginate(10);
        return response()->view('cms.Income-Type.index', ['income_types' => $income_types]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return response()->view('cms.Income-Type.create');
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
        $validator = Validator($request->all(), [
            'name' => 'required|string|min:3',
            'details'=>'required|string|min:3',
            'active' => 'boolean',
        ]);
        if(!$validator->fails()){
            $income_type = new IncomeType();
            $income_type->name = $request->get('name');
            $income_type->details = $request->get('details');
            $income_type->active = $request->get('active');
            $income_type->user_id = $request->user()->id;
            $isSaved = $income_type->save();
            return response()->json(['message'=>$isSaved ? "Income Type Created successfully" : "Failed to create Income Type"],$isSaved ? 201 : 400);
        }else{
            return response()->json(['message'=>$validator->getMessageBag()], 400);
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
        $income_type = IncomeType::findOrFail($id);
        return response()->view('cms.Income-Type.edit', ['income_type' => $income_type]);
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
        $validator = Validator($request->all(), [
            'name' => 'required|string|min:3',
            'details'=>'required|string|min:3',
            'active' => 'boolean',
        ]);
        if(!$validator->fails()){
            $income_type = IncomeType::findOrFail($id);
            $income_type->name = $request->get('name');
            $income_type->details = $request->get('details');
            $income_type->active = $request->get('active');
            $income_type->user_id = $request->user()->id;
            $isSaved = $income_type->save();
            return response()->json(['message'=>$isSaved ? "Income Type Updated successfully" : "Failed to Updated Income Type"],$isSaved ? 200 : 400);
        }else{
            return response()->json(['message'=>$validator->getMessageBag()], 400);
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
        $isDeleted = IncomeType::destroy($id);
        return response()->json(['message' =>
         $isDeleted ?
             "Income Type Deleted successfully" : "Falid to Delete Income Type"],
            $isDeleted ? 200 : 400);
    }
}
