<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\UserDetail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = Auth::user();

        if ($request->expectsJson()) {
            return response()->json($guide);
        }

        return view('admin.setting.profile', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    public function edit(User $user)
    {
        $user = Auth::user();
        return view('admin.setting.profile', compact('user'));
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
        if($request->password){
            $this->validate(request(), [
                        'name' => 'required',
                        'email' => 'required|email|max:190|unique:users,email,'.$id,
                        'password' => 'min:6|confirmed',
                    ]);
            }else {
            $this->validate(request(), [
                        'name' => 'required',
                        'email' => 'required|email|max:190|unique:users,email,'.$id,
                    ]);
            }
        
        $user = User::findOrFail($id);
        $user->name = request('name');
        $user->email = request('email');
        if($request->password){
            $user->password = bcrypt(request('password'));
        }
        $user->save();

        return back()->with('success','Data has been changed!');
    }

    public function changeava(Request $request, $id){
        $this->validate(request(), [
            'photo' => 'image|mimes:jpeg,jpg,png,gif|required|max:10000',
        ]);
        

        $user = UserDetail::where('user_id',$id)->first();
        $photo = Storage::disk('public')->putFile('user',$request->file('photo'), 'public');
        $user->photo = asset('storage/'.$photo);
        $user->save();

        return back()->with('success','Photo has been changed!');
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
