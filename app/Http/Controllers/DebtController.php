<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Debt;
use App\Models\DebtUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DebtController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $debts = Debt::with(['user_debt', 'currency'])->paginate();
        return response()->view('cms.debits.index', ['debts' => $debts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $debt_users = DebtUsers::all();
        $currencies = Currency::where('active', true)->get();
        return response()->view('cms.debits.create', ['debt_users' => $debt_users, 'currencies' => $currencies]);
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
        // $request->validate([
        //     'vsdfvz', 'digits:value|max:value'
        // ]);
        $validator = Validator($request->all(), [
            'debt_user_id' => 'required|numeric|exists:debt_users,id',
            'currency_id' => 'required|numeric|exists:currencies,id',
            'total' => 'required|numeric',
            'remain' => 'required|max:'.$request->get('total'),
            'date' => 'required',
            'debt_type' => 'required|in:Creditor,Debtor',
            'payment_type' => 'required|in:single,multi',
            'description' => 'required|string|min:10'
        ]);
        if(!$validator->fails()){
            $debt =new Debt();
            $debt->total = $request->get('total');
            $debt->remain = $request->get('remain');
            $debt->debt_type = $request->get('debt_type');
            $debt->payment_type = $request->get('payment_type');
            $debt->description = $request->get('description');
            $debt->date = $request->get('date');
            $debt->debt_user_id = $request->get('debt_user_id');
            $debt->image = 'fdszgdfg';
            $isSaved = $debt->save();
            return response()->json(['message' => $isSaved ? 'Debit created successfully' : 'Failed to create Debit'], $isSaved ? 201 : 400);
        }else{
            return response()->json(['message' => $validator->getMessageBag()->first()], 400);
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
