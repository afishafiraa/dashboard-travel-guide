<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\UserDetail;

class UserController extends Controller
{

    public $successStatus = 200;

    public function login(Request $request){
      //Autentikasi user
      if(Auth::attempt([
        'email' => request('email'),
        'password' => request('password')
      ])){
        $user = Auth::user();
        // Cek apakah user sudah verifikasi email
        if (!$user->hasVerifiedEmail()) {
          return response()->json([
            'success'=>false,
            'error' => 'Please verify your email address to sign in to your account.'
          ]);
        } 
        // Cek status pengguna
        if ($user->status == 0) {
          return response()->json([
            'success'=>false,
            'error' => 'Your account is deactivated, please call the customer service to activate your account.'
          ]);
        } 
        // Ambil role pengguna
        $role = $user->getRoleNames()->first();
        
        return response()->json([
          'success'=>true,
          'user' => $user,
          'role' => $role,
          'token' => $user->createToken('API_Travel')->accessToken
        ]);
      }
      else{
        return response()->json(['success'=>false,'error'=>'Your email or password was incorrect. Please try again'], 400);
      }
    }

    public function register(Request $request)
    {
      //Validasi data
      $validator = Validator::make($request->all(), [
          'name' => 'required',
          'email' => 'required|email|unique:users',
          'password' => 'required|min:6|confirmed',
      ]);
		  if ($validator->fails()) {
        return response()->json(['success'=>false,'error'=>$validator->errors()], 400);
      }
      // User dibuat sesuai dengan data yang dimasukkan
      $user = User::create([
        'name'=>$request->name,
        'email'=>$request->email,
        'password'=>bcrypt($request->password),
      ]);
      // Set role user menjadi guide
      $user->assignRole('guide');
      // Buat detail user
      $detail = new UserDetail;
      if ($request->phone) {
        $detail->photo = $request->phone;
      }
      $detail->user_id = $user->id;
      $detail->save();

      // Kirim email verifikasi user
      $user->sendEmailVerificationNotification();
		  return response()->json([
        'success'=>true,
        'message'=>'To continue, please check your email address to verify your account',
      ]);
    }

    public function getUser() {
      $user = Auth::guard('api')->user();
      $detail = UserDetail::where('user_id', $user->id)->first();
      return response()->json([
        'success'=>true,
        'user' => $user, 
        'detail' => $detail
      ], $this->successStatus); 
    }
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
      $id = Auth::id();
      $validator = Validator::make($request->all(), [
        'name' => 'required|max:255',
        'phone_number' => 'max:14',
        'email' => 'required|email|max:190|unique:users,email,'.$id,
        'photo' => 'image|mimes:jpeg,jpg,png,gif|max:2048',
      ]);
      if ($validator->fails()) {
        return response()->json(['success'=>false,'error'=>$validator->errors()], 401);
      }
      $data = User::findOrFail($id);
      $data->name = $request->name;
      $data->email = $request->email;
      $data->save();

      $detail = UserDetail::where('user_id', $id)->first();
      if ($request->photo) {
        $photo = Storage::disk('public')->putFile('user',$request->file('photo'), 'public');
        $detail->photo = asset('storage/'.$photo);
      }
      $detail->address = $request->address;
      $detail->phone_number = $request->phone_number;
      $detail->ocupation = $request->ocupation;
      $detail->save();
      
      return response()->json([
        'success'=>true,
        'user'=>$data,
        'detail'=>$detail,
      ]);
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
