<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    public function index()
    {
        return view('web.notification.form');
    }

    public function send(Request $request)
    {
        $title = $request->input('title');
        $body = $request->input('body');
        $topic = 'broadcast';
        $send = fcm()
            ->toTopic($topic) // $topic must an string (topic name)
            ->notification([
                'title' => $title,
                'body' => $body,
            ])
            ->send();
        if($send != null){
            return redirect()->route('notification.index')->with('success', 'Success Send Notification');
        }else{
            return redirect()->route('notification.index')->with('danger', 'Something went wrong');
        }
    }
}
