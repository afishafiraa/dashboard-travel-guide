<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\RewardCollection;
use App\Reward;
use App\User;
use App\TrxReedem;
use Carbon\Carbon;

class RewardController extends Controller
{
  
    public $successStatus = 200;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return new RewardCollection(Reward::all());
    }

    public function reedem($id){
      $user = \Auth::guard('api')->user();
      $reward = Reward::findOrFail($id);
      if ($user->points >= $reward->point) {
        $data = TrxReedem::create([
          'user_id'=>$user->id,
          'reward_id'=>$id,
          'created_at'=>Carbon::now(),
        ]);
        $user->decrement('points', $reward->point);      
      } else {
        return response()->json([
          'success'=>false,
          'error'=>'Points not enough',
        ]);
      }
      
      return response()->json([
        'success'=>true,
        'data'=>$reward,
      ]);
    }

}
