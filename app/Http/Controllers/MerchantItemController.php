<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MerchantItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class MerchantItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index (Request $request)
    {
    
        $items = MerchantItem::all();


      if ($request->expectsJson()) {
        return response()->json($items);
      }

      return view('admin.places.merchant_detail', compact('items'));
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
      // Validasi data form
      Validator::make($request->all(), [
        'name' => 'required|max:255',
        'price' => 'required|numeric|min:0',
        'photo' => 'image|mimes:jpeg,jpg,png,gif|max:2048',
      ])->validate();
      
      // Membuat data baru
      $data = new MerchantItem;
      $data->merchant_id = $request->merchant_id;
      $data->name = $request->name;
      $data->description = $request->description;
      // melakukan cek apakah ada isian foto
      if ($request->photo) {
        $photo = Storage::disk('public')->putFile('items',$request->file('photo'), 'public');
        $data->photo = asset('storage/'.$photo);
      }
      $data->price = $request->price;
      $data->save();

      return redirect()->back()->with('success','Item has been created!');
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
      $data = MerchantItem::where('id', $id)->first();

      return view('admin.places.merchant_detail', compact('data'));
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
      // validasi data form
      Validator::make($request->all(), [
        'name' => 'required|max:255',
        'price' => 'required|numeric|min:0',
        'photo' => 'image|mimes:jpeg,jpg,png,gif|max:2048',
      ])->validate();
      // mencari data yang akan diupdate
      $data = MerchantItem::findOrFail($id);
      //set value baru dan simpan ke database
      $data->name = $request->name;
      $data->description = $request->description;
      if ($request->photo) {
        $photo = Storage::disk('public')->putFile('items',$request->file('photo'), 'public');
        $data->photo = asset('storage/'.$photo);
      }
      $data->price = $request->price;
      $data->save();
      // kembali ke tampilan sebelumnya dengan alert sukses
      return redirect()->back()->with('success','Item has been changed!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
      $data = MerchantItem::destroy($id);
      \Alert::success('Success', 'Data has been deleted!');

      if ($request->expectsJson()) {
        return response()->json($data);
      }
    }
}
