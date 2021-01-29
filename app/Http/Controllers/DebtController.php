<?php

namespace App\Http\Controllers;

use App\Helpers\FileUpload;
use App\Models\Currency;
use App\Models\Debt;
use App\Models\DebtUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DebtController extends Controller
{
    use FileUpload;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //

        $debts = $request->user('user')->debts()->with(['user_debt', 'currency'])->paginate();
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
        $validator = Validator($request->all(), [
            'debt_user_id' => 'required|numeric|exists:debt_users,id',
            'currency_id' => 'required|numeric|exists:currencies,id',
            'image'=>'required|image|mimes:png,jpg,jpeg|max:2048',
            'total' => 'required|numeric',
            'remain' => 'required|numeric|max:'.$request->get('total'),
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
            $debt->currency_id = $request->get('currency_id');
            if ($request->hasFile('image')) {
                $this->uploadFile($request->file('image'), 'images/debts/', 'public', 'user_debt' . time());
                $debt->image = $this->filePath;
            }
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
        $debt_users = DebtUsers::all();
        $currencies = Currency::where('active', true)->get();
        $debt = Debt::with(['currency', 'user_debt'])->findOrFail($id);
        return response()->view('cms.debits.edit', [
            'debt' => $debt,
            'debt_users' => $debt_users,
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
    public function update(Request $request, $id)
    {
        //
        $validator = Validator($request->all(), [
            'debt_user_id' => 'required|numeric|exists:debt_users,id',
            'currency_id' => 'required|numeric|exists:currencies,id',
            'total' => 'required|numeric',
            'image'=>'required|image|mimes:png,jpg,jpeg|max:2048',
            'remain' => 'required|max:'.$request->get('total'),
            'date' => 'required',
            'debt_type' => 'required|in:Creditor,Debtor',
            'payment_type' => 'required|in:single,multi',
            'description' => 'required|string|min:10'
        ]);
        if(!$validator->fails()){
            $debt =Debt::findOrFail($id);
            $debt->total = $request->get('total');
            $debt->remain = $request->get('remain');
            $debt->debt_type = $request->get('debt_type');
            $debt->payment_type = $request->get('payment_type');
            $debt->description = $request->get('description');
            $debt->date = $request->get('date');
            $debt->debt_user_id = $request->get('debt_user_id');
            $debt->currency_id = $request->get('currency_id');
            if ($request->hasFile('image')) {
                $isDeleted = Storage::disk('public')->delete($debt->image);
                if ($isDeleted) {
                    $this->uploadFile($request->file('image'), 'images/debts/', 'public', 'user_debt' . time());
                    $debt->image = $this->filePath;
                }else{
                    return response()->json(['message' => "Failed to Delete Image"], 400);
                }
            }
            $isSaved = $debt->save();
            return response()->json(['message' => $isSaved ? 'Debit Updated successfully' : 'Failed to Updated Debit'], $isSaved ? 201 : 400);
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
        $debt = Debt::findOrFail($id);
        $isDeleted = Storage::disk('public')->delete($debt->image);
        if($isDeleted){
            $isDeleted=$debt->delete();
            return response()->json(['message'=> $isDeleted ? 'Debt Deleted successfuly' : 'Faild to delete Debt'], $isDeleted ? 200:400);
        }else{
            return response()->json(['message'=> 'Faild to delete User image'], 400);
        }
    }
}
