<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TrxQrcode;
use DataTables;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      // Mengambil data tahun yang ada pada tabel transaksi
      $years = TrxQrcode::selectRaw('YEAR(trx_time) as year')
      ->orderBy('trx_time', 'desc')->distinct()->get();

      return view('admin.transaction_index', compact('years'));
    }

    public function monthlyAjax($date = null){
      // Menentukan tanggal yang dipilih pengguna
      if($date == null){
        $month = date('m');
        $year = date('Y');
      }else {
        $time = strtotime($date);
        $month = date("m", strtotime("first day of this month", $time));
        $year = date("Y", strtotime("first day of this month", $time));
      }

      // Mengambil data berdasarkan tanggal yang dipilih
      $laporan = TrxQrcode::with('qrcode.user', 'qrcode.promo.item.merchant')
        ->orderBy('trx_time','desc')
        ->whereYear('trx_time', $year)->whereMonth('trx_time', $month)
        ->get();

      // Membuat array yang akan ditampilkan dalam bentuk tabel
      $array = array();
      foreach ($laporan as $d) {
        $arr['user'] = $d->qrcode->user->name;
        $arr['promo'] = $d->qrcode->promo->item->name ." ". 
          $d->qrcode->promo->category." " .$d->qrcode->promo->value;
        $arr['merchant'] = $d->qrcode->promo->item->merchant->name;
        $arr['date'] = $d->trx_time;
        $array[] = $arr;
      }

      return Datatables::of($array)
      ->addIndexColumn()
      ->rawColumns(['action'])
      ->make(true);
    }

    public function getMonthly($date = null){
      // Menentukan tanggal yang dipilih pengguna
      if($date == null){
        $date = date('Y-m');
        $time = strtotime("now");
        $end = date("Y-m", strtotime("+1 month", $time));

        $begin = new \DateTime( $date.'-01' );
        $end = new \DateTime( $end.'-01' );
      }else {
        $time = strtotime($date);
        $end = date("Y-m", strtotime("+1 month", $time));

        $begin = new \DateTime( $date.'-01' );
        $end = new \DateTime( $end.'-01' );
      }

      // Menentukan hari yang ada pada bulan yang dipilih
      $interval = new \DateInterval('P1D');
      $daterange = new \DatePeriod($begin, $interval ,$end);

      //Membuat array yang digunakan untuk menyimpan data setiap harinya
      $day = array();
      $value = array();
      foreach($daterange as $date){
        $day[] = $date->format("j");
        $count = TrxQrcode::
          whereDate('trx_time', $date->format("Y-m-d"))
          ->count();
        $value[] = $count;
      }
      // Mengembalikan array dalam bentuk json
      return response()->json([
        'status'=>'success',
        'day'=>$day,
        'value'=>$value,
      ]);
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
        //
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
