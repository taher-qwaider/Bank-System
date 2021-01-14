<?php

namespace App\Http\Controllers;

use App\Models\ExpenseType;
use Illuminate\Http\Request;

class ExpenseTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $expense_types = ExpenseType::paginate(10);
        return response()->view('cms.Expense-Type.index', ['expense_types' => $expense_types]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return response()->view('cms.Expense-Type.create');
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
            $expense_type = new ExpenseType();
            $expense_type->name = $request->get('name');
            $expense_type->details = $request->get('details');
            $expense_type->active = $request->get('active');
            $expense_type->user_id = $request->user()->id;
            $isSaved = $expense_type->save();
            return response()->json(['message'=>$isSaved ? "Expense Type Created successfully" : "Failed to create Expense Type"],$isSaved ? 201 : 400);
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
        $expense_type = ExpenseType::findOrFail($id);
        return response()->view('cms.Expense-Type.edit', ['expense_type' => $expense_type]);
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
            $expense_type = ExpenseType::findOrFail($id);
            $expense_type->name = $request->get('name');
            $expense_type->details = $request->get('details');
            $expense_type->active = $request->get('active');
            $expense_type->user_id = $request->user()->id;
            $isSaved = $expense_type->save();
            return response()->json(['message'=>$isSaved ? "Expense Type Updated successfully" : "Failed to Updated Expense Type"],$isSaved ? 200 : 400);
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
        $isDeleted = ExpenseType::destroy($id);
        return response()->json(['message' =>
         $isDeleted ?
             "Income Type Deleted successfully" : "Falid to Delete Income Type"],
            $isDeleted ? 200 : 400);
    }
}
