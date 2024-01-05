<?php

namespace App\Http\Controllers;

use App\Models\PushNotification;
use Illuminate\Http\Request;

class PushNotificationController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notifications = PushNotification::orderBy('created_at', 'desc')->get();
        return view('notifications.index', compact('notifications'));
    }
    public function bulksend(Request $req){
        $pushNotification = new PushNotification();
        $pushNotification->title = $req->input('title');
        $pushNotification->body = $req->input('body');
        $pushNotification->img = $req->input('img');
        $pushNotification->save();

        $url = 'https://fcm.googleapis.com/fcm/send';
        $dataArr = array('click_action' => 'FLUTTER_NOTIFICATION_CLICK', 'id' => $req->id,'status'=>"done");
        $notification = array('title' =>$req->title, 'body' => $req->body, 'image'=> $req->img, 'sound' => 'default', 'badge' => '2',);
        $arrayToSend = array('to' => "/topics/all", 'notification' => $notification, 'data' => $dataArr, 'priority'=>'high');
        $fields = json_encode ($arrayToSend);
        $headers = array (
            'Authorization: key=' . "AAAAgWcxSiI:APA91bEoGm4DzCyoIZv0ci3QoDFok5srtTBKyeL08wcIopiojF8dzPf_PCmh7NJ0K9pqMGRYiUZNJanc-gkmfZ-_2RF-Vs-_z7Yi14L1PBQu5xfvYq2HR-nPSE62AxtXlMk6NsebPd3D",
            // 'Authorization: key=' . "AAAAIJBU8Cs:APA91bHFV4-6kpHNXJktZVDe_LX1PhFKTULJ91Bdh3lCOhnG9pmLV50GZeu7f7U96aNN6bRQIjkvvD8s-TC2efWMXGgagt-i7HpmbkDONDAHAydwfyt7MtJzj5zJPKWIquCI1v9O54s-",
            'Content-Type: application/json'
        );
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );
        $result = curl_exec ( $ch );
        //var_dump($result);
        curl_close ( $ch );
        return redirect()->back()->with('success', 'Notification Sent successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PushNotification  $pushNotification
     * @return \Illuminate\Http\Response
     */
    public function destroy(PushNotification $notification)
    {
        // dd($notification->title);
        $notification->delete();
        return back()->with('success', 'Notification deleted successfully');

    }
}
