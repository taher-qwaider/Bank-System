<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class UserApiAuthController extends Controller
{
    //

    public function login(Request $request)
    {
        $validator = Validator($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string'
        ]);
        if (!$validator->fails()) {
            $user = User::where('email', $request->get('email'))->first();
            if (Hash::check($request->get('password'), $user->password)) {
                // $this->revokeActiveTokens($user->id);
                if (!$this->checkAccessTokens($user->id)) {
                    $token = $user->createToken('mobile-user');
                    $user->setAttribute('token', $token->accessToken);
                    return response()->json(['status' => true, 'message' => 'Loggid in successfuly', 'user' => $user], 200);
                } else {
                    return response()->json(['status' => false, 'message' => 'Failed to login, logout frome other devices'], 401);
                }
            } else {
                return response()->json(['status' => false, 'message' => 'Failed to login check inputs'], 400);
            }
        } else {
            return response()->json(['status' => false, 'message' => $validator->getMessageBag()->first()], 400);
        }
    }
    private function revokeActiveTokens($userId)
    {
        DB::table('oauth_access_tokens')
            ->where('user_id', $userId)
            ->where('revoked', false)
            ->update([
                'revoked' => true,
            ]);
    }
    private function checkAccessTokens($userId)
    {
        return DB::table('oauth_access_tokens')
            ->where('user_id', $userId)
            ->where('revoked', false)
            ->exists();
    }
    public function logout(Request $request)
    {
        $isLoggedOut = $request->user('api')->token()->revoke();
        return response()->json(
            [
                'status' => true,
                'message' => $isLoggedOut ? 'loggout successfuly' : 'Failed to loggout'
            ],
            $isLoggedOut ? 200 : 400
        );
    }
    public function loginGCT(Request $request){
        $validator = Validator($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string'
        ]);

        if (!$validator->fails()) {
            $user = User::where('email', $request->get('email'))->first();
            $this->revokeActiveTokens($user->id);
            $response = Http::asForm()
                ->post('http://127.0.0.1:8001/oauth/token', [
                    'grant_type' => 'password',
                    'client_id' => '2',
                    'client_secret' => 'Tg2YtSzCTDF6PkadxzuBPnZ82KGyRklUyuHyENpV',
                    'username' => $request->get('email'),
                    'password' => $request->get('password'),
                    'scope' => '*',
                ]);
            $user->setAttribute('token', $response->json()['access_token']);
            $user->setAttribute('refresh_token', $response->json()['refresh_token']);
            return response()->json(['status' => true, 'object' => $user], 200);
        }else{
            return response()->json(['status' => false, 'message' => $validator->getMessageBag()->first()], 400);
        }

    }
    public function logoutGCT(Request $request){
        $token = $request->user('api')->token();
        $isRevoked = DB::table('oauth_refresh_tokens')
        ->where('access_token_id', $token->id)
        ->update([
            'revoked'=>true
        ]);
        if($isRevoked){
            $isRevoked = $token->revoke();
            return response()->json(['status' => $isRevoked ? true : false, 'message' => $isRevoked ?  'Loggout successfuly' : 'Falid to Loggout'], 400);
        }else{
            return response()->json(['status' => false, 'message' => 'Falid to Loggout'], 400);
        }
    }
}
