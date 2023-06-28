<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Merchant;
use App\Promo;
use App\MerchantItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class MerchantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
      //
    }

    public function indexStore(Request $request)
    {
      $store = Merchant::whereHas('category', function ($query) {
        $query->where('name','store');
      })->where('status', 0)
      ->orderBy('created_at', 'desc')->get();

      $highlight = Merchant::whereHas('category', function ($query) {
        $query->where('name','store');
      })->where('status', 1)
      ->orderBy('updated_at', 'desc')->get();
      // dd($highlight);
      if ($request->expectsJson()) {
        return response()->json($store);
      }

      return view('admin.places.store_index', compact('store', 'highlight'));
    }

    public function indexHotel(Request $request)
    {
        
      $hotel = Merchant::whereHas('category', function ($query) {
        $query->where('name','hotel');
      })->where('status', 0)
      ->orderBy('created_at', 'desc')->get();
        
      $highlight = Merchant::whereHas('category', function ($query) {
        $query->where('name','hotel');
      })->where('status', 1)
      ->orderBy('updated_at', 'desc')->get();


      if ($request->expectsJson()) {
        return response()->json($hotel);
      }

      return view('admin.places.hotel_index', compact('hotel', 'highlight'));
    }

    public function indexRestaurant(Request $request)
    {
        
      $restaurant = Merchant::whereHas('category', function ($query) {
        $query->where('name','restaurant');
      })->where('status', 0)
      ->orderBy('created_at', 'desc')->get();
        
      $highlight = Merchant::whereHas('category', function ($query) {
        $query->where('name','restaurant');
      })->where('status', 1)
      ->orderBy('updated_at', 'desc')->get();


      if ($request->expectsJson()) {
        return response()->json($restaurant);
      }

      return view('admin.places.restaurant_index', compact('restaurant', 'highlight'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('admin.places.merchant_create');
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
        'photo' => 'image|mimes:jpeg,jpg,png,gif|required|max:10000',
      ]);
      if ($validator->passes()) {
        $tourism = new Merchant;
        $tourism->category_id = $request->category_id;
        $tourism->name = $request->name;
        $tourism->description = $request->description;
        $photo = Storage::disk('public')->putFile('merchant',$request->file('photo'), 'public');
        $tourism->photo = asset('storage/'.$photo);
        $tourism->address = $request->address;
        $tourism->latitude = $request->latitude;
        $tourism->longitude = $request->longitude;
        $tourism->save();
        if ($request->category_id==1){
            return redirect()->route('admin.places.storeindex')->with('success','Data Has Been Created!');
        }
        else if ($request->category_id==2){
            return redirect()->route('admin.places.hotelindex')->with('success','Data Has Been Created!');
        }
        else if ($request->category_id==3){
            return redirect()->route('admin.places.restaurantindex')->with('success','Data Has Been Created!');
        }        
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
      // Mengambil data merchant beserta item yang dimiliki
      $data = Merchant::where('id', $id)->with('item')->first();
      // Mengambil data promo aktif yang dimiliki merchant 
      $promos = Promo::whereHas('item.merchant', function($q) use($id){
        $q->where('id', $id);
      })->whereDate('end_time', '>=', date('Y-m-d'))
      ->with('item')->get();

      return view('admin.places.merchant_detail', compact('data', 'promos'));
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
            'address' => 'required|max:255',
            'name' => 'required|max:255',
          ]);
          if ($validator->passes()) {
            $tourism = Merchant::findOrFail($id);
            $tourism->name = $request->name;
            $tourism->description = $request->description;
            $tourism->address = $request->address;
            $tourism->latitude = $request->latitude;
            $tourism->longitude = $request->longitude;
            $tourism->save();
            if ($request->category_id==1){
                return redirect()->route('admin.places.storeindex')->with('success','Data Has Been Changed!');
            }
            else if ($request->category_id==2){
                return redirect()->route('admin.places.hotelindex')->with('success','Data Has Been Changed!');
            }
            else if ($request->category_id==3){
                return redirect()->route('admin.places.restaurantindex')->with('success','Data Has Been Changed!');
            }        
          } 
          else return redirect()->back()->withErrors($validator);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
      $data = Merchant::destroy($id);
      if ($request->expectsJson()) {
        return response()->json($data);
      }
    }
    
    public function highlight($id){
      $data = Merchant::findOrFail($id);
      if($data->status == 1){
        $data->status = 0;
      }else {
        $data->status = 1;
      }
      $data->save();
      return response()->json($data);
    }
}
