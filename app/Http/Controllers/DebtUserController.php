<?php

namespace App\Http\Controllers;

use App\Models\DebitUsers;
use App\Models\Debt;
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
        $debt_users = DebtUsers::all();
        $debts = Debt::all();
        foreach($debt_users as $debt_user){
            $count = 0;
            foreach($debts as $debt){
                if($debt->user_debt->id == $debt_user->id){
                    $count++;
                }
            }
            $debt_user->setAttribute('debt_count', $count);
        }
        return response()->view('cms.debt-user.index', [
            'debt_users' => $debt_users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return response()->view('cms.debt-user.create');
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
        $user_debt = DebtUsers::findOrFail($id);
        return response()->view('cms.debt-user.edit', [
            'user_debt' =>$user_debt
        ]);
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
        $validator = validator($request->all(), [
            'first_name' => 'required|string|min:2|max:30',
            'last_name' => 'required|string|min:2|max:30',
            'telephone' => 'required|numeric|digits:9',
            'mobile' => 'required|numeric|digits:10|unique:debt_users,mobile, ' . $id,
            'gender' => 'required|in:M,F|string',
            'address' => 'required|string',

        ]);
        if(!$validator->fails()){
            $debit_user =DebtUsers::findOrFail($id);
            $debit_user->first_name = $request->get('first_name');
            $debit_user->last_name = $request->get('last_name');
            $debit_user->mobile = $request->get('mobile');
            $debit_user->telephone = $request->get('telephone');
            $debit_user->address = $request->get('address');
            $debit_user->gender = $request->get('gender');
            $isSaved = $debit_user->save();
            return response()->json(['message' => $isSaved ? 'User Debit Updated successfully' : 'Failed to Update User Debit'], $isSaved ? 200 : 400);
        }else{
            return response()->json(['message' => $validator->getMessageBag()->first()], 400);

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
        $isDeleted = DebtUsers::destroy($id);
        return response()->json([
            'message' => $isDeleted ? 'User Debt Deleted successfuly' : 'Falied to Delete User Debt'
        ], $isDeleted ? 200 : 400);
    }
}
