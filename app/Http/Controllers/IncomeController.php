<?php

namespace App\Http\Controllers;

use App\Helpers\FileUpload;
use App\Models\Currency;
use App\Models\Income;
use App\Models\IncomeType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class IncomeController extends Controller
{
    use FileUpload;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        //
        $income_type =IncomeType::with('incomes')->findOrFail($id);
        return response()->view('cms.Income.index', [
            'income_type' => $income_type
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        //
        $currencies = Currency::where('active', true)->get();
        return response()->view('cms.Income.create', [
            'income_type_id' => $id,
            'currencies' => $currencies
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        //
        $validator = Validator($request->all(), [
            'total' => 'required|numeric|min:-1',
            'currency_id' => 'required|numeric|exists:currencies,id',
            'date' => 'required|date',
            'image' => 'required|image|mimes:jpg,png,jpeg|max:2048'
        ]);
        if(!$validator->fails()){
            $income = new Income();
            $income->total = $request->get('total');
            $income->date = $request->get('date');
            $income->currency_id = $request->get('currency_id');
            $income->income_type_id = $id;
            if ($request->hasFile('image')) {
                $this->uploadFile($request->file('image'), 'images/incomes/', 'public', 'user_income' . time());
                $income->image = $this->filePath;
            }
            $isSaved = $income->save();
            return response()->json(['message' => $isSaved ? 'Income created successfully' : 'Failed to create Income'], $isSaved ? 201 : 400);

        }else{
            return response()->json(['message'=> $validator->getMessageBag()->first()], 400);
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
    public function edit($income_type_id, $income_id)
    {
        //
        $currencies = Currency::where('active', true)->get();
        $income = Income::findOrFail($income_id);
        return response()->view('cms.Income.edit', [
            'income' => $income,
            'income_type_id' => $income_type_id,
            'income_id' => $income_id,
            'currencies' => $currencies
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $income_type_id, $income_id)
    {
        //
        $validator = Validator($request->all(), [
            'total' => 'required|numeric|min:-1',
            'currency_id' => 'required|numeric|exists:currencies,id',
            'date' => 'required|date',
        ]);
        if(!$validator->fails()){
            $income = IncomeType::findOrFail($income_type_id)->incomes()->where('id', $income_id)->first();
            $income->total = $request->get('total');
            $income->date = $request->get('date');
            $income->currency_id = $request->get('currency_id');
            $isSaved = $income->save();
            return response()->json(['message' => $isSaved ? 'Income Updated successfully' : 'Failed to Update Income'], $isSaved ? 201 : 400);
        }else{
            return response()->json(['message'=> $validator->getMessageBag()->first()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($income_type_id, $income_id)
    {
        //
        $income = IncomeType::findOrFail($income_type_id)->incomes()->where('id', $income_id)->first();
        $isDeleted =Storage::disk('public')->delete($income->image);
        if($isDeleted){
            $isDeleted = $income->delete();
            return response()->json(['message' => $isDeleted ? 'Income Deleted successfuly' : 'Failed to Delete Income'], $isDeleted ? 200 : 400);
        }else{
            return response()->json(['message' => 'Failed to Delete Income Image'], 400);
        }
    }
}
