<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tourism;
use App\City;
use App\GalleryTourism;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;


class TourismController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $tourism = Tourism::orderBy('created_at', 'desc')->get();
      $city= City::select('id','name')->get();

      if ($request->expectsJson()) {
        return response()->json($tourism);
      }

      return view('admin.tourism.tourism_index', compact('tourism', 'city'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $city= City::select('id','name')->get();
      return view('admin.tourism.tourism_create', compact('city'));
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
        'address' => 'required|max:255',
        'name' => 'required|max:255',
        'description' => 'required',
        'longitude' => 'required',
        'latitude' => 'required',
        'photo' => 'image|mimes:jpeg,jpg,png,gif|required|max:10000',
      ]);
      if ($validator->passes()) {
        $tourism = new Tourism;
        $tourism->name = $request->name;
        $tourism->city_id = $request->city;
        $tourism->description = $request->description;
        $photo = Storage::disk('public')->putFile('tourism',$request->file('photo'), 'public');
        $tourism->photo = asset('storage/'.$photo);
        $tourism->address = $request->address;
        $tourism->latitude = $request->latitude;
        $tourism->longitude = $request->longitude;
        $tourism->save();
        return redirect()->route('admin.tourism.index')->with('success','Data Has Been Created!');
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
      $data = Tourism::with('gallery')
      ->where('id', $id)
      ->first();  
      //User itu manggil model yg berisi table. select tinggal panggil kolom. 
      //User::with('detail')->get(); -> contoh manggil table lain istilahnya join table. 
      //pelajarin dokumentasi laravel
      // dd($data);
      return view('admin.tourism.tourism_detail', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
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
        'address' => 'max:255',
        'name' => 'max:255',
      ]);
      if ($validator->passes()) {
        $tourism = Tourism::findOrFail($id);
        if ($request->city_id) {
          $tourism->city_id=$request->city_id;
        }
        $tourism->name = $request->name;
        $tourism->address = $request->address;
        if ($request->photo) {
          $photo = Storage::disk('public')->putFile('tourism',$request->file('photo'), 'public');
          $tourism->photo = asset('storage/'.$photo);
        }
        $tourism->latitude = $request->latitude;
        $tourism->longitude = $request->longitude;
        $tourism->save();
        return redirect()->route('admin.tourism.index')->with('success','Data Has Been changed!');
      } 
      else {
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
      $tourism = Tourism::destroy($id);
      if ($request->expectsJson()) {
        return response()->json($tourism);
      }
    }
}