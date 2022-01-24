<?php

namespace App\Http\Controllers;

use App\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Request as REQ;

class AnnouncementController extends Controller
{
    public function getAllAnnouncements()
    {
        $announcements = Announcement::all();
        if(REQ::is('api/*'))
        return response()->json([
            'announcements' => $announcements
        ], 200);
        return view('feeds/all_announcements')->with('announcements', $announcements);
    }

    public function getSingleAnnouncement($announcementId)
    {
        $announcement = Announcement::find($announcementId);
        if (!$announcementId) {
            return response()->json([
                'error' => 'Announcement not found'
            ], 404);
        }
        return response()->json([
            'announcement' => $announcement
        ], 200);
    }

    public function postAnnouncement(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'news' => 'required',
            'date' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
                'status' => false
            ], 404);
        }

        $announcement = new Announcement();
        $announcement->news = $request->input('news');
        $announcement->date = $request->input('date');

        $announcement->save();
        if(REQ::is('api/*'))

        return response()->json([
            'announcement' => $announcement
        ], 200);
        return back()->with('message', 'Announcement added successfully');

    }

    public function putAnnouncement(Request $request, $announcementId)
    {
        $announcement = Announcement::find($announcementId);
        if (!$announcement) {
            return response()->json([
                'error' => 'Announcement not found'
            ], 404);
        }

        $announcement->update([
            'news' => $request->input('news'),
            'date' => $request->input('date'),
        ]);
        $announcement->save();
        if(REQ::is('api/*'))

        return response()->json([
            'announcement' => $announcement
        ], 200);
        return back()->with('message', 'Announcement edited successfully');

    }

    public function deleteAnnouncement($announcementId)
    {
        $announcement = Announcement::find($announcementId);
        if (!$announcement) {
            return response()->json([
                'error' => 'Announcement does not exist'
            ], 404);
        }

        $announcement->delete();
        if(REQ::is('api/*'))
        return response()->json([
            'message' => 'Announcement deleted successfully'
        ], 200);
        return back()->with('message', 'Announcement deleted successfully');

    }
}
