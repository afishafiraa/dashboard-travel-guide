<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\City;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $city = City::all();

        if ($request->expectsJson()) {
          return response()->json($city);
        }
  
        return view('admin.city.city_index', compact('city'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('admin.city.city_create');
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
            'longitude' => 'required',
            'latitude' => 'required',
          ]);
          if ($validator->passes()) {
            $city = new City;
            $city->name = $request->name;
            $city->latitude = $request->latitude;
            $city->longitude = $request->longitude;
            $city->save();
            return redirect()->route('admin.city.index')->with('success','Data Has Been Created!');
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
        $data = City::where('id', $id)->first();  //User itu manggil model yg berisi table. select tinggal panggil kolom. 
      //User::with('detail')->get(); -> contoh manggil table lain istilahnya join table. 
      //pelajarin dokumentasi laravel
            
      return view('admin.city.city_index', compact('data'));
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
            'name' => 'required|max:255',
            'longitude' => 'required',
            'latitude' => 'required',
          ]);
          if ($validator->passes()) {
            $city = City::findOrFail($id);
            $city->name = $request->name;
            $city->latitude = $request->latitude;
            $city->longitude = $request->longitude;
            $city->save();
            return redirect()->route('admin.city.index')->with('success','Data Has Been changed!');
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
    public function destroy(Request $request, $id)
    {
        $city = City::destroy($id);
      if ($request->expectsJson()) {
        return response()->json($city);
      }
    }
}
