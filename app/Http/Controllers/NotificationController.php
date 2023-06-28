<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Notification;
use App\Libraries\Firebase;
use App\Libraries\Push;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use LaravelFCM\Message\Topics;
use FCM;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notif = Notification::all();
        return view('admin.notification',compact('notif'));
    }
    
    /**
     * Get AJAX Data from table Laporan.
     *
     * @return \Illuminate\Http\Response
     */
    public function getEmail()
    {
        $users = \App\User::all();

        $array['query'] = "Unit";
        foreach ($users as $user) {
          $array['suggestions'][] = $user->email;
        }

        return response()->json($array);
        
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
      $validator = Validator::make($request->all(), [
          'title' => 'required|max:191',
          'message' => 'required|max:1024',
          'type' => 'required',
        ]);
        if ($validator->passes()) {
          // Buat notifikasi baru untuk disimpan di basis data
          $notif = new Notification;
          $notif->title = $request->title;
          $notif->message = $request->message;
          $notif->type = $request->type;
          $notif->status = 0;
          // Cek tipe notifikasi
          if ($request->type == 'topic') {
            $notif->receiver = $request->topics;
          }else {
            $notif->receiver = $request->receiver;
          }
          $notif->save();

          return redirect()->route('admin.notification.index',compact('notif'))
          ->with('success','Data Has Been Created!');
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
        $validator = Validator::make($request->all(), [
          'title' => 'required|max:191',
          'message' => 'required|max:1024',
        ]);
        if ($validator->passes()) {
          $notif = Notification::findorfail($id);
          $notif->title = $request->title;
          $notif->message = $request->message;
          $notif->save();
          if ($request->action == 'post') {
            $this->send($id);
          }
          return redirect()->route('admin.notification.index',compact('notif'))->with('success','Data Has Been Changed!');
        }
        else return redirect()->back()->withErrors($validator);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,Request $request)
    {
      $notif = Notification::destroy($id);
      \Alert::success('Success', 'Data has been deleted!');
      
      return response()->json([
        'success'=>true
      ]); 
    }

    public function send($id)
    {
      // Mencari data notifikasi yang akan dikirim
      $notif = Notification::findorfail($id);
      
      if ($notif->type == 'topic') {
        // jalankan fungsi kirim multiple device
        $fcm = $this->sendTopicFCM($notif->title, $notif->message, $notif->receiver);
      }else {
        // jalankan fungsi kirim specific device
        $user = \App\User::where('email', $notif->receiver)->first();
        $fcm = sendFCM($notif->title, $notif->message, $user->fcm_token);
      }
      // cek apakah pengiriman notif berhasil
      if($fcm){
        $notif->status = 1;
        $notif->save();
        return redirect()->route('admin.notification.index')->with('success','Success sending notification!');
      }else {
        return redirect()->route('admin.notification.index')->with('error','Error sending notification!');
      }
    }

    public function sendTopicFCM($title, $message, $receiver){
      // membuat notifikasi builder dengan pesan yang akan dikirim
      $notificationBuilder = new PayloadNotificationBuilder($title);
      $notificationBuilder->setBody($message)
      ->setSound('default');
      $notification = $notificationBuilder->build();

      // membuat topik yang dituju
      $topic = new Topics();
      $topic->topic($receiver);

      //mengirim notifikasi
      $topicResponse = FCM::sendToTopic($topic, null, $notification, null);
      
      return response()->json($topicResponse->isSuccess());
    }

    public function sendFCM($title, $message, $receiver){
      // membuat notifikasi builder dengan pesan yang akan dikirim
      $notificationBuilder = new PayloadNotificationBuilder($title);
      $notificationBuilder->setBody($message)
        ->setSound('default');
      $notification = $notificationBuilder->build();
      
      //mengirim notifikasi ke perangkat yang dituju
      $downstreamResponse = FCM::sendTo($receiver, null, $notification, null);
      
      //mengembalikan hasil pengiriman notifikasi
      if($downstreamResponse->numberSuccess() > 0){
        return response()->json(true);
      }else {
        return response()->json(false);
      }
    }
}
