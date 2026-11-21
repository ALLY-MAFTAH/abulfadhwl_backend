<?php

namespace App\Http\Controllers;

use App\Rules\PlainText;
use App\Models\Announcement;
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
            'news' => ['required', 'string', 'max:3000', new PlainText()],
            'date' => ['required', 'string', 'max:60', new PlainText()],

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
        $announcement->translations = \App\Support\Translations::collect($request, ['news']);

        $announcement->save();
        \App\Services\FcmV1::signalRefresh('announcements');
        if(REQ::is('api/*'))

        return response()->json([
            'announcement' => $announcement
        ], 200);
        return back()->with('success', 'Announcement added successfully');

    }

    public function putAnnouncement(Request $request, $announcementId)
    {
        $announcement = Announcement::find($announcementId);
        if (!$announcement) {
            return response()->json([
                'error' => 'Announcement not found'
            ], 404);
        }

        $request->validate([
            'news' => ['required', 'string', 'max:3000', new PlainText()],
            'date' => ['required', 'string', 'max:60', new PlainText()],
        ]);

        $announcement->update([
            'news' => $request->input('news'),
            'date' => $request->input('date'),
            'translations' => \App\Support\Translations::collect($request, ['news']),
        ]);
        $announcement->save();
        \App\Services\FcmV1::signalRefresh('announcements');
        if(REQ::is('api/*'))

        return response()->json([
            'announcement' => $announcement
        ], 200);
        return back()->with('success', 'Announcement edited successfully');

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
        \App\Services\FcmV1::signalRefresh('announcements');
        if(REQ::is('api/*'))
        return response()->json([
            'success' => 'Announcement deleted successfully'
        ], 200);
        return back()->with('success', 'Announcement deleted successfully');

    }
}
