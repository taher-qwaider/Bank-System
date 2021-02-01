<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\SubUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class InvitationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $invitations = $request->user('user')->reciveInvitations()->with('sendUser')->get();
        return response()->view('cms.Invitation.friend', [
            'invitations' => $invitations,
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
        return response()->view('cms.Invitation.inviate');
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
            'email' => 'required|email|exists:users,email',
            'message' => 'required|string|min:3'
        ]);
        if(!$validator->fails()){
            $sender_id = $request->user('user')->id;
            // $resever_id = User::where('email' ,'==', $request->get('email'))->get()-;
            $resever_id =DB::table('users')->where('email', $request->get('email'))->first()->id;
            $inviate =new Invitation();
            $inviate->sender_user_id = $sender_id;
            $inviate->receiver_user_id = $resever_id;
            $inviate->message =$request->get('message');
            $inviate->status = 'Waiting';
            $isSaved = $inviate->save();
            return response()->json(['message' => $isSaved ? 'Inviatetion send successfully' : 'Failed to send Inviatetion'], $isSaved ? 200 : 400);
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
        $validator = Validator($request->all(), [
            'status' => 'required|in:Accepted,Rejected'
        ]);
        if(!$validator->fails()){
            $invitation = Invitation::findOrFail($id);
            $invitation->status = $request->get('status');
            if($request->get('status') == 'Accepted'){
                $sub_user = new SubUser();
                $sub_user->main_user_id = $invitation->sender_user_id;
                $sub_user->sub_user_id = $invitation->receiver_user_id;
                $sub_user->manege_sub = true;
                $isSaved = $sub_user->save();
            }
            $isSaved = $invitation->save();
            return response()->json(['message' => $isSaved ? 'invitation Updated successfully' : 'Failed to Update invitation'], $isSaved ? 200 : 400);
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
    }
}
