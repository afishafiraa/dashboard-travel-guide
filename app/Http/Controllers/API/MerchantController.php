<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\MerchantCollection;
use Illuminate\Support\Facades\Auth;
use App\Merchant;

class MerchantController extends Controller
{
  
    public $successStatus = 200;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return new MerchantCollection(Merchant::all());
    }

    public function category($id)
    {
      return new MerchantCollection(Merchant::where('category_id', $id)->get());
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
      Validator::make($request->all(), [
        'address' => 'required|max:255',
        'name' => 'required|max:255',
        'photo' => 'image|mimes:jpeg,jpg,png,gif|required|max:10000',
      ])->validate();
      
      $tourism = new Merchant;
      //$tourism->city_id=1;
      $tourism->category_id = $request->category_id;
      $tourism->name = $request->name;
      $tourism->description = $request->description;
      $photo = Storage::disk('public')->putFile('merchant',$request->file('photo'), 'public');
      $tourism->photo = asset('storage/'.$photo);
      $tourism->address = $request->address;
      $tourism->latitude = $request->latitude;
      $tourism->longitude = $request->longitude;
      // dd($request);
      $tourism->save();

      return response()->json([
        'status' => $this->successStatus,
        'result' => $tourism
      ]); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $date = date('Y-m-d');
      $data = Merchant::where('id', $id)->with(['item.promo' => function ($query) use ($date){
        $query->whereDate('end_time','>=', $date);
      }])->get();
      return new MerchantCollection($data);
    }
    /**
     * Display the specified resource. According to logged in user
     *
     * @return \Illuminate\Http\Response
     */
    public function user()
    {
      $user = Auth::user();
      $id = $user->merchant_id;
      if (!$id) {
        return response()->json([
          'status'=>'error',
          'message'=>'Merchant not assigned.',
        ]);
      }
      return new MerchantCollection(Merchant::where('id', $id)->with('item.promo')->get());
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
    public function update(Request $request)
    {
      $user = Auth::user();
      $id = $user->merchant_id;
      if (!$id) {
        return response()->json([
          'status'=>'error',
          'message'=>'Merchant not found.',
        ]);
      }
      Validator::make($request->all(), [
        'address' => 'required|max:191',
        'name' => 'required|max:50',
        'latitude' => 'required',
        'longitude' => 'required',
      ])->validate();
      
      $data = Merchant::findOrFail($id);
      $data->name = $request->name;
      $data->address = $request->address;
      $data->description = $request->description;
      if ($request->photo) {
        $photo = Storage::disk('public')->putFile('merchant',$request->file('photo'), 'public');
        $data->photo = asset('storage/'.$photo);
      }
      $data->latitude = $request->latitude;
      $data->longitude = $request->longitude;
      $data->save();

      return response()->json([
        'status' => $this->successStatus,
        'result' => $data
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
