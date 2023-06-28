<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MerchantItem;
use App\Promo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class PromoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $promos = Promo::with('item.merchant')
      ->whereDate('end_time', '>=', date('Y-m-d'))
      ->orderBy('created_at', 'desc')
      ->get();

      return view('admin.promo.promo_index', compact('promos'));
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
      // Validasi data
      Validator::make($request->all(), [
        'value' => 'required|numeric|min:0',
        'max_cut' => 'numeric|min:0',
        'category' => 'required',
        'start_time' => 'required|after_or_equal:today',
        'end_time' => 'required|after_or_equal:start_time',
      ])->validate();
      // Membuat dan menyimpan data baru ke basis data
      $data = new Promo;
      $data->item_id = $request->item_id;
      $data->value = $request->value;
      $data->description = $request->description;
      $data->category = $request->category;
      $data->max_cut = $request->max_cut;
      $data->start_time = $request->start_time;
      $data->end_time = $request->end_time;
      $data->save();
      //Mengembalikan ke halaman semula dengan alert sukses
      return redirect()->back()-> with('success','Promo has been added!');
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
      Validator::make($request->all(), [
        'value' => 'required|numeric|min:0',
        'max_cut' => 'numeric|min:0',
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

      return redirect()->back()-> with('success','Promo has been changed!');
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
      \Alert::success('Success', 'Data has been deleted!');

      return response()->json([
        'success'=>true
      ]); 
    }
}
