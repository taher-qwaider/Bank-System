<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $wallets = $request->user('user')->wallets()->with('currency')->get();
        return response()->view('cms.Wallets.index', ['wallets'=>$wallets]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $currencies = Currency::where('active', true)->get();
        return response()->view('cms.Wallets.create', ['currencies'=>$currencies]);
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
            'total' => 'numeric|min:-10',
            'currency_id' => 'numeric|exists:currencies,id',
            'active' => 'boolean'
        ]);
        if(!$validator->fails()){
            $wallet = new Wallet();
            $wallet->name = $request->get('name');
            $wallet->active = $request->get('active');
            $wallet->total = $request->get('total');
            $wallet->user_id = $request->user('user')->id;
            $wallet->currency_id = $request->get('currency_id');
            $isSaved = $wallet->save();
            return response()->json(['message' => $isSaved ? 'Wallet created successfully' : 'Failed to create Wallet'], $isSaved ? 201 : 400);
        }else{
            return response()->json(['message' =>$validator->getMessageBag()->first()], 400);
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
        $wallet = Wallet::with('currency')->findOrFail($id);
        $currencies = Currency::where('active', true)->get();
        return response()->view('cms.Wallets.edit', ['wallet' => $wallet, 'currencies' => $currencies]);
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
            'total' => 'numeric|min:-10',
            'currency_id' => 'numeric|exists:currencies,id',
            'active' => 'boolean'
        ]);
        if(!$validator->fails()){
            $wallet = Wallet::findOrFail($id);
            $wallet->name = $request->get('name');
            $wallet->active = $request->get('active');
            $wallet->total = $request->get('total');
            $wallet->user_id = $request->user('user')->id;
            $wallet->currency_id = $request->get('currency_id');
            $isSaved = $wallet->save();
            return response()->json(['message' => $isSaved ? 'Wallet Updated successfully' : 'Failed to Updated Wallet'], $isSaved ? 200 : 400);
        }else{
            return response()->json(['message' =>$validator->getMessageBag()->first()], 400);
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
        $isDeleted = Wallet::destroy($id);
        return response()->json(['message' => $isDeleted ? "Wallet Deleted successfuly" : "Falil to Delete Wallet"], $isDeleted ? 200 : 400);
    }
}
