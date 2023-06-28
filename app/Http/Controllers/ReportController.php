<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\TrxQrcode;
use App\Exports\UserExport;
use App\Exports\TransactionExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexU()
    {  
        $years = User::selectRaw('YEAR(created_at) as year')->orderBy('created_at', 'desc')->distinct()->get();

        return view('admin.report.user_index',compact('years'));
    }

    public function indexT()
    { 
        $years = TrxQrcode::selectRaw('YEAR(trx_time) as year')->orderBy('trx_time', 'desc')->distinct()->get();

        return view('admin.report.transaction_index', compact('years'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function monthlyAjax($date = null){
        if($date == null){
          $month = date('m');
          $year = date('Y');
          $laporan = User::orderBy('created_at','asc')
          ->whereYear('created_at', $year)->whereMonth('created_at', $month)
          ->get();
        }else {
          $time = strtotime($date);
          $month = date("m", strtotime("first day of this month", $time));
          $year = date("Y", strtotime("first day of this month", $time));
          $laporan = User::orderBy('created_at','asc')
          ->whereYear('created_at', $year)->whereMonth('created_at', $month)
          ->get();
        }
        $array = array();
        $i = 1;
        foreach ($laporan as $d) {
          $arr['no'] = $i++;
          $arr['user'] = $d->qrcode->user->name;
          $arr['promo'] = $d->qrcode->promo->item->name ." ".$d->qrcode->promo->category." " .$d->qrcode->promo->value;
          $arr['merchant'] = $d->qrcode->promo->item->merchant->name;
          $arr['date'] = $d->trx_time;
            $arr['action'] = '<button type="button" class="btn btn-info btnEdit" id="" data-toggle="modal" data-target="#editModal"><i class="nav-icon icon-pencil"></i></button><button type="button" class="btn btn-danger btnDelete" id=" "><i class="nav-icon icon-trash"></i></button><button type="button" class="btn btn-success btnDetail" id=" "><i class="nav-icon icon-info"></i></button>';
            $array[] = $arr;
        }
        return response()->json([
            'data' => $array
        ]);
      }

    public function getMonthly($date = null){
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
        $interval = new \DateInterval('P1D');
        $daterange = new \DatePeriod($begin, $interval ,$end);
        
        $day = array();
        $value = array();
        foreach($daterange as $date){
          $day[] = $date->format("j");
          
          $count = User::
          whereDate('created_at', $date->format("Y-m-d"))
          ->count();
  
          $value[] = $count;
        }
        return response()->json([
          'status'=>'success',
          'day'=>$day,
          'value'=>$value,
        ]);
    }

    public function export_excelU($date = null)
    {
      if($date == null){
        $month = date('m');
        $year = date('Y');
      }else {
        $time = strtotime($date);
        $month = date("m", strtotime("first day of this month", $time));
        $year = date("Y", strtotime("first day of this month", $time));
        // dd($month, $year);
      }
      return Excel::download(new UserExport($month,$year), 'UserReport.xlsx');
    }

    public function export_excelT($date = null)
    {
      if($date == null){
        $month = date('m');
        $year = date('Y');
      }else {
        $time = strtotime($date);
        $month = date("m", strtotime("first day of this month", $time));
        $year = date("Y", strtotime("first day of this month", $time));
        // dd($month, $year);
      }
      return Excel::download(new TransactionExport($month,$year), 'TransactionReport.xlsx');
    }

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
