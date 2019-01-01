<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;
use Auth;

class AuthController extends Controller
{

    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:web')->except('logout');
    }

    public function showFormLogin()
    {
        return view('login')->with('title','Login');
    }
    
    public function username()
    {
        $identity  = request()->get('username');
        $fieldName = 'username';
        request()->merge([$fieldName => $identity]);
        return $fieldName;
    }

    /**
     * Validate the user login.
     * @param Request $request
     */
    protected function validateLogin(Request $request)
    {
        $this->validate(
            $request,
            [
                'username' => 'required|string',
                'password' => 'required|string',
            ],
            [
                'username.required' => 'Username is required',
                'password.required' => 'Password is required',
            ]
        );
    }
    
    /**
     * @param Request $request
     * @throws ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        $request->session()->flash('status', 'Something went wrongs!');
        throw ValidationException::withMessages(
            [
                'error' => [trans('auth.failed')],
            ]
        );
    }

    protected function guard(){
        return Auth::guard('web');
    }

    protected function redirectTo()
    {
        return route('index');
    }
}
