<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Merchant;
use App\Qr;
use App\TrxQrcode;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\URL;
use Illuminate\Contracts\Encryption\DecryptException;

class QrCodeController extends Controller
{
  public $successStatus = 200;

  public function generate($id){
    $user = Auth::guard('api')->user();
    // Cek role user
    if (!$user->hasRole('guide')) {
      return response()->json([
        'success'=>false,
        'error' => 'You need guide account to make QR Code.'
      ]);
    }
    //Membuat batas berlaku kode QR 
    $dt = Carbon::now()->addWeek();
    //Membuat data QR
    $data = Qr::create([
      'user_id'=>$user->id,
      'promo_id'=>$id,
      'expiry_time'=>$dt,
    ]);
    
    //Data di dalam QR dengan format TIMESTAMP#ID#QRGUIDE#USERID
    $date = new \DateTime();
    $qr_data = $date->getTimestamp()."%23".$data->id."%23QRGUIDE%23".$user->id;

    //Membuat gambar QR
    $image = QrCode::errorCorrection('Q')->format('png')
    ->size(300)->merge('\public\images\icon.png')->generate($qr_data);
    $path = 'qrcode/qr-' . $data->id .'-'. time() . '.png';
    Storage::put('public/'.$path, $image);

    return response()->json([
      'success'=>true,
      'result'=>asset('storage/'.$path)
    ]);
  }

  public function scan($id){
    //Mentranslasi kode QR
    $encoded = explode("#",urldecode($id));
    //Mencari isi QR
    $qr = Qr::where('id', $encoded[1])->with('promo.item')->first();
    if (date('Y-m-d') > $qr->expiry_time) {
      return response()->json([
        'success'=>false,
        'error' => 'QR Code Expired.'
      ]);
    }
    $user = User::findOrFail($encoded[3]);
    $merchant = Merchant::findOrFail($qr->promo->item->merchant_id);
    //Mencatat hasil scan
    $dt = Carbon::now();
    $data = TrxQrcode::create([
      'qrcode_id'=>$encoded[1],
      'trx_time'=>$dt,
    ]);
    //Menambahkan poin ke guide
    $point = 10;
    if ($merchant->status == 1) {
      $point *= 2;
    }
    $user->increment('points', $point);
    
    return response()->json([
      'success'=>true,
      'user'=>$user,
      'promo'=>$qr->promo,
    ]);
  }
}
