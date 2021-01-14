<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CurrencyContoroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $currencies = Currency::paginate(10);
        return response()->view('cms.Currencies.index', ['currencies' => $currencies]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return response()->view('cms.Currencies.create');
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
            'active' => 'boolean',
        ]);
        if(!$validator->fails()){
            $currency = new Currency();
            $currency->name = $request->get('name');
            $currency->active = $request->get('active');
            $isSaved = $currency->save();
            return response()->json(['message'=>$isSaved ? "Currency Created successfully" : "Failed to create Currency"],$isSaved ? 201 : 400);
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
        $currency = Currency::findOrFail($id);
        return response()->view("cms.Currencies.edit", ['currency'=>$currency]);

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
            'active' => 'boolean',
        ]);
        if(!$validator->fails()){
            $currency = Currency::findOrFail($id);
            $currency->name = $request->get('name');
            $currency->active = $request->get('active');
            $isSaved = $currency->save();
            return response()->json(['message'=>$isSaved ? "Currency Updated successfully" : "Failed to Update Currency"],$isSaved ? 200 : 400);
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
        $IsDeleted = Currency::destroy($id);
        if($IsDeleted){
            return response()->json(['title'=>'Deleted!', 'massege'=>'Currency Deleted Successfuly', 'icon'=>'success'],200);
        }else{
            return response()->json(['title'=>'Failed!', 'massege'=>'Failed to delete the Currency', 'icon'=>'error'],400);
        }
    }
}
