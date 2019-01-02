<?php

namespace App\Http\Controllers\Web;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use File;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('created_at','DESC')->paginate(5);
        return view('web.user.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('web.user.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'username' => 'required|max:255|unique:users',
            'password' => 'required|min:6',
            'picture' => 'required|image'
        ]);
        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        }
        $image = $request->file('picture');
        $name = $image->hashName();
        if($image = $image->move(env('PLACE_PROFILE_PATH'), $name)){
            $user = new User();
            $user->fill($request->input());
            $user->picture = $name;
            $user->is_active = '1';
            if($user->save()){
                return redirect()->route('user.index')->with('success', 'New user has been added');
            }
        }else{
            return back()->withErrors(['msg' => 'Something went wrongs'])->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('web.user.form',['user'=>$user]);
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email',
            'username' => 'required|max:255',
            'picture' => 'image'
        ]);
        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $user = User::find($id);
        if($user->picture != null){
            File::delete(env('PLACE_PROFILE_PATH').$user->picture);
        }
        if($request->hasFile('picture')){
            $image = $request->file('picture');
            $name = $image->hashName();
            if($image = $image->move(env('PLACE_PROFILE_PATH'), $name)){
                $user->picture = $name;
            }
        }
        $user->fill($request->input());
        $user->is_active = '1';
        if($user->update()){
            return redirect()->route('user.index')->with('success', 'User has been updated');
        }else{
            return back()->withErrors(['msg' => 'Something went wrongs'])->withInput();
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
        $user = User::find($id);
        if($user->picture != null){
            File::delete(env('PLACE_PROFILE_PATH').$user->picture);
        }
        if($user->delete()){
            return redirect()->route('user.index')->with('success', 'User has been delete');
        }else{
            return redirect()->route('user.index')->with('danger', 'Something went wrongs');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function switch($id)
    {
        $user = User::find($id);
        $status = (!$user->is_active) ? "Active"  : "Deactive";
        $user->is_active = (!$user->is_active);
        if($user->update()){
            return back()->with('success', "User has been $status");
        }else{
            return back()->with('danger', 'Something went wrongs');
        }
    }
}
