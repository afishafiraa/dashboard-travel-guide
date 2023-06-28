<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserDetail;
use App\Merchant;
use App\TrxQrcode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserGuideController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $guide = User::role('guide')->orderBy('created_at', 'desc')->get();

      if ($request->expectsJson()) {
        return response()->json($guide);
      }

      return view('admin.users.guide_index', compact('guide'));
    }

    public function changeStatus(Request $request, $id){
      $user = User::findOrFail($id);
      $status = $user->status == 1 ? 0 : 1;
      $user->status = $status;
      $user->save();

      return response()->json(['success'=>'status change successfully']);
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
      $validator = Validator::make($request->all(), [
        'email' => 'required|email|max:255|unique:users',
        'name' => 'required|max:255',
        'password' => 'required|min:6|string|confirmed',
      ]);
      
      if ($validator->passes()) {
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        $user->assignRole('guide');
        $detail = new UserDetail;
        $detail->user_id = $user->id;
        $detail->save();
        $user->markEmailAsVerified();
        return redirect()->route('admin.guide.index')->with('success','Data Has Been Created!');
      } 
      else return redirect()->back()->withErrors($validator);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = User::where('id', $id)->with('detail', 'merchant', 'qr.promo')->first();
        $trans = TrxQrcode::with('qrcode.promo.item.merchant')
        ->whereHas('qrcode', function ($q) use ($id) {
        $q->where('user_id', $id);
        })->get();
        return view('admin.users.guide_detail', compact('data', 'id','trans'));
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
      $validator = Validator::make($request->all(), [
        'name' => 'max:255',
        'phone_number' => 'max:14',
        'email' => 'email|max:190|unique:users,email,'.$id,
      ]);

      if ($validator->passes()) {
          $data = User::findOrFail($id);
          $detail = UserDetail::where('user_id', $id)->first();
          $data->name = $request->name;
          $data->email = $request->email;
          $detail->phone_number = $request->phone_number;
          $detail->address = $request->address;
          $detail->ocupation = $request->ocupation;
          if($request->photo){
            $photo = Storage::disk('public')->putFile('user',$request->file('photo'), 'public');
            $detail->photo = $photo;
          }
          $data->save();
          $detail->save();
          return redirect()->route('admin.guide.index')->with('success','Data has been changed!');
      } else {
          return redirect()->back()->withErrors($validator);            
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
      $user = User::destroy($id);
      if ($request->expectsJson()) {
        return response()->json($user);
      }
    }
}
