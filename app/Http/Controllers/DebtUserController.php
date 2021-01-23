<?php

namespace App\Http\Controllers;

use App\Models\DebitUsers;
use App\Models\DebtUsers;
use Illuminate\Http\Request;

class DebtUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return response()->view('cms.debits.create-user-debit');
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
        $validator = validator($request->all(), [
            'first_name' => 'required|string|min:2|max:30',
            'last_name' => 'required|string|min:2|max:30',
            'telephone' => 'required|numeric|digits:9',
            'mobile' => 'required|numeric|digits:10|unique:debt_users,mobile',
            'gender' => 'required|in:M,F|string',
            'address' => 'required|string',

        ]);
        if(!$validator->fails()){
            $debit_user = new DebtUsers();
            $debit_user->first_name = $request->get('first_name');
            $debit_user->last_name = $request->get('last_name');
            $debit_user->mobile = $request->get('mobile');
            $debit_user->telephone = $request->get('telephone');
            $debit_user->address = $request->get('address');
            $debit_user->gender = $request->get('gender');
            $isSaved = $debit_user->save();
            return response()->json(['message' => $isSaved ? 'User Debit created successfully' : 'Failed to create User Debit'], $isSaved ? 201 : 400);
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
