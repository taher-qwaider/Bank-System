<?php

namespace App\Http\Controllers;

use App\Helpers\FileUpload;
use App\Models\Debt;
use App\Models\DebtPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DebtPaymentController extends Controller
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
        $debt_payments =Debt::findOrFail($id)->payments;
        return response()->view('cms.debt-payments.index', [
            'debt_payments' => $debt_payments,
            'debt_id' => $id
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
        return response()->view('cms.debt-payments.create', [
            'debt_id'=>$id
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
            'amount' => 'required|numeric|min:-1',
            'remain' => 'required|numeric|min:-1|max:' .$request->get('amount'),
            'date' => 'required|date',
            'status' => 'required|in:Paid,Postponed,Waitting',
            'image' => 'image|mimes:png,jpg,jpeg|max:2048',
        ]);
        if(!$validator->fails()){
            $debt_payment =new DebtPayment();
            $debt_payment->amount = $request->get('amount');
            $debt_payment->remain = $request->get('remain');
            $debt_payment->payment_date = $request->get('date');
            $debt_payment->status = $request->get('status');
            if ($request->hasFile('image')) {
                $this->uploadFile($request->file('image'), 'images/debts/payments/', 'public', 'payment_' . time());
                $debt_payment->image = $this->filePath;
            }
            $debt_payment->debt_id = $id;
            $isSaved = $debt_payment->save();
            return response()->json(['message' => $isSaved ? 'Payment Created Successfuly' : 'Failed to Create Payment'], $isSaved ? 200 : 400);
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
    public function edit($debt_id, $payment_id)
    {
        //
        $payment = Debt::findOrFail($debt_id)->payments()->where('id', $payment_id)->first();
        return response()->view('cms.debt-payments.edit', [
            'payment'=>$payment,
            'debt_id' =>$debt_id,
            'payment_id' => $payment_id
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $debt_id , $payment_id)
    {
        //
        $validator = Validator($request->all(), [
            'amount' => 'required|numeric|min:-1',
            'remain' => 'required|numeric|min:-1|max:' .$request->get('amount'),
            'date' => 'required|date',
            'status' => 'required|in:Paid,Postponed,Waitting',
        ]);
        if(!$validator->fails()){
            $debt_payment = Debt::findOrFail($debt_id)->payments()->where('id', $payment_id)->first();
            $debt_payment->amount = $request->get('amount');
            $debt_payment->remain = $request->get('remain');
            $debt_payment->payment_date = $request->get('date');
            $debt_payment->status = $request->get('status');
            $debt_payment->debt_id = $debt_id;
            $isSaved = $debt_payment->save();
            return response()->json(['message' => $isSaved ? 'Payment Updated Successfuly' : 'Failed to Update Payment'], $isSaved ? 200 : 400);
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
    public function destroy($debt_id, $payment_id)
    {
        //
        $payment = Debt::findOrFail($debt_id)->payments()->where('id', $payment_id)->first();
        $isDeleted =Storage::disk('public')->delete($payment->image);
        if($isDeleted){
            $isDeleted = $payment->delete();
            return response()->json(['message' => $isDeleted ? 'Payment Deleted successfuly' : 'Failed to Delete Payment'], $isDeleted ? 200 : 400);
        }else{
            return response()->json(['message' => 'Failed to Delete Payment Image'], 400);
        }
    }
}
