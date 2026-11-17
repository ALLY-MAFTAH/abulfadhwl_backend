<?php

namespace App\Http\Controllers;

use App\Models\PushNotification;
use App\Services\FcmV1;
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

        $result = FcmV1::sendToTopic(
            'all',
            (string) $req->title,
            (string) $req->body,
            $req->img,
            ['click_action' => 'FLUTTER_NOTIFICATION_CLICK', 'id' => $req->id, 'status' => 'done']
        );
        if (!$result['ok']) {
            return redirect()->back()->with('error', 'Notification was saved but NOT sent: ' . $result['body']);
        }
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
