<?php

namespace App\Http\Controllers\Api;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Carbon\Carbon;
use App\Models\User;

class AuthController extends Controller
{

    protected $response = [
        'data' => [
            'msg' => 'Some text here',
        ],
        'meta' => [
            'total' => '0'
        ]
    ];

    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] username
     * @param  [string] password
     * @return [string] message
     */
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'username' => 'required|max:255|unique:users',
            'password' => 'required|min:6',
        ]);
        if ($validator->fails()) {
            $this->response['data']['msg'] = $validator->errors()->first();
            return response()->json($this->response);
        }
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => $request->password,
            'is_active' => '1'
        ]);
        if($user->save()){
            $this->response['data']['msg'] = "Successfully created user!";
            return response()->json($this->response, 201);
        }
        $this->response['data']['msg'] = "Something went wrong!";
        return response()->json($this->response, 204);
        
    }

    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request)
    {
        $credentials = request(['username', 'password']);
        $credentials['is_active'] = '1';
        if(!Auth::attempt($credentials)){
            $this->response['data']['msg'] = "Unauthorized";
            return response()->json($this->response, 401);
        }
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        if($token->save())
        {
            $this->response['data'] = [
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString()
            ];
            return response()->json($this->response, 201);
        }

        $this->response['data']['msg'] = "Something went wrong!";
        return response()->json($this->response, 204);
        
    }
  
    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        if($request->user()->token()->revoke()){
            $this->response['data']['msg'] = "Successfully logged out";
            return response()->json($this->response, 201);
        }
        $this->response['data']['msg'] = "Something went wrong!";
        return response()->json($this->response, 204);
    }
  
    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        if($request->user() != null){
            $this->response['data'] = $request->user();
            return response()->json($this->response);
        }
        $this->response['data']['msg'] = "Something went wrong!";
        return response()->json($this->response, 204);
    }

    /**
     * Set default authenticating User
     *
     * @return string
     */
    public function username()
    {
        return 'username';
    }
}
