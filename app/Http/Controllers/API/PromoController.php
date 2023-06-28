<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\PromoCollection;
use Illuminate\Support\Facades\Auth;
use App\Promo;
use App\MerchantItem;

class PromoController extends Controller
{
  
    public $successStatus = 200;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $promos = Promo::with('item')
      ->whereDate('end_time', '>=', date('Y-m-d'))->get();
      foreach ($promos as $promo) {
        $promo->merchant_id = $promo->item->merchant_id;
      }
      return new PromoCollection($promos);
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
        'value' => 'required|min:0',
        'category' => 'required',
        'start_time' => 'required|after_or_equal:today',
        'end_time' => 'required|after_or_equal:start_time',
      ])->validate();
      
      $data = new Promo;
      $data->item_id = $request->item_id;
      $data->value = $request->value;
      $data->description = $request->description;
      $data->category = $request->category;
      $data->max_cut = $request->max_cut;
      $data->start_time = $request->start_time;
      $data->end_time = $request->end_time;
      $data->save();

      return response()->json([
        'status' => $this->successStatus,
        'result' => $data
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
      $promos = Promo::with('item')->whereHas('item', function($q) use($id){
        $q->where('merchant_id', $id);
      })
      ->whereDate('end_time', '>=', date('Y-m-d'))->get();
      return new PromoCollection($promos);
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
          'success'=>false,
          'error'=>'Merchant not assigned.',
        ]);
      }
      return new PromoCollection(
        Promo::with('item')->whereHas('item', function ($q) use ($id) {
          $q->where('merchant_id', $id);
        })->whereDate('end_time', '>=', date('Y-m-d'))->get()
      );
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
      Validator::make($request->all(), [
        'value' => 'required|min:0',
        'category' => 'required',
        'start_time' => 'required',
        'end_time' => 'required|after_or_equal:start_time',
      ])->validate();
      
      $data = Promo::findOrFail($id);
      $data->value = $request->value;
      $data->description = $request->description;
      $data->category = $request->category;
      $data->max_cut = $request->max_cut;
      $data->start_time = $request->start_time;
      $data->end_time = $request->end_time;
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
      $data = Promo::destroy($id);
      return response()->json([
        'success'=>true,
        'message'=>'Data successfully deleted.',
      ]); 
    }
}
